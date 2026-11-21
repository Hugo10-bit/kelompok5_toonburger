<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use RuntimeException;

/**
 * ToonBurgerOperationsService
 *
 * Mesin operasional dan analitik terpadu untuk ekosistem aplikasi web Toon Burger.
 * Kelas ini menangani seluruh kebutuhan kalkulasi bisnis mulai dari metrik ringkasan
 * dashboard admin, estimasi waktu tunggu dapur berbasis beban antrean (batching),
 * validasi kode promo dan kalkulasi tagihan checkout, perhitungan tarif pengantaran
 * berbasis zona kelurahan di Banjarbaru, distribusi tugas antar stasiun dapur,
 * audit stok bahan baku harian, hingga pembuatan laporan tutup shift kasir.
 *
 * Seluruh metode dirancang bersifat deterministik, aman terhadap tipe data (strict types),
 * serta selaras dengan zona waktu operasional utama WITA (Asia/Makassar).
 *
 * @package    App\Services
 * @author     Toon Burger Engineering Team
 * @version    3.1.0
 * @since      2026-11-21
 */
class ToonBurgerOperationsService
{
    /**
     * Konfigurasi standar zona waktu, jam operasional, dan kapasitas dapur Toon Burger.
     */
    private const TIMEZONE = 'Asia/Makassar';
    private const STORE_OPEN_HOUR = 17;
    private const STORE_CLOSE_HOUR = 22;
    private const BASE_PREP_MINUTES = 6;
    private const MAX_KITCHEN_CAPACITY_PER_BATCH = 8;
    private const LOYALTY_POINT_RATIO = 1000;
    private const DEFAULT_TAX_RATE = 0.10;
    private const MAX_DELIVERY_RADIUS_KM = 15.0;

    /**
     * Bobot waktu persiapan tambahan untuk setiap kategori menu (satuan menit).
     *
     * @var array<string, int>
     */
    private array $categoryPrepWeights = [
        'burger'   => 4,
        'snacks'   => 3,
        'minuman'  => 1,
        'paket'    => 6,
        'seasonal' => 5,
    ];

    /**
     * Pemetaan stasiun dapur berdasarkan kategori produk untuk penyeimbangan beban kerja.
     *
     * @var array<string, string>
     */
    private array $stationRoutingMap = [
        'burger'   => 'grill_and_assembly',
        'snacks'   => 'deep_fryer_station',
        'minuman'  => 'beverage_counter',
        'paket'    => 'multi_station_combo',
        'seasonal' => 'grill_and_assembly',
    ];

    /**
     * Ambang batas stok minimum bahan baku utama dapur sebelum memicu status peringatan.
     *
     * @var array<string, array{min: int, unit: string, category: string}>
     */
    private array $inventoryThresholds = [
        'australian_beef_patty' => [
            'min'      => 25,
            'unit'     => 'pcs',
            'category' => 'protein',
        ],
        'artisanal_brioche_bun' => [
            'min'      => 30,
            'unit'     => 'pcs',
            'category' => 'bakery',
        ],
        'melted_cheddar_slice' => [
            'min'      => 40,
            'unit'     => 'lembar',
            'category' => 'dairy',
        ],
        'secret_toon_sauce_ml' => [
            'min'      => 1500,
            'unit'     => 'ml',
            'category' => 'condiment',
        ],
        'smoky_bbq_glaze_ml' => [
            'min'      => 1200,
            'unit'     => 'ml',
            'category' => 'condiment',
        ],
        'french_fries_pack' => [
            'min'      => 15,
            'unit'     => 'pack',
            'category' => 'frozen',
        ],
        'chicken_wings_pcs' => [
            'min'      => 36,
            'unit'     => 'potong',
            'category' => 'protein',
        ],
        'chicken_nuggets_pcs' => [
            'min'      => 50,
            'unit'     => 'potong',
            'category' => 'frozen',
        ],
        'onion_rings_pack' => [
            'min'      => 12,
            'unit'     => 'pack',
            'category' => 'frozen',
        ],
        'kraft_packaging_box' => [
            'min'
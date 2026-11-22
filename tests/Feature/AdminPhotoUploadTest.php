<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminPhotoUploadTest extends TestCase
{
    use RefreshDatabase;

    private function makePngDataUri(int $w = 12, int $h = 12): string
    {
        $img = imagecreatetruecolor($w, $h);
        imagealphablending($img, false);
        imagesavealpha($img, true);
        $bg = imagecolorallocatealpha($img, 56, 88, 80, 30);
        imagefill($img, 0, 0, $bg);
        ob_start();
        imagepng($img);
        $binary = ob_get_clean();

        return 'data:image/png;base64,' . base64_encode($binary);
    }

    private function makeJpgDataUri(int $w = 12, int $h = 12): string
    {
        $img = imagecreatetruecolor($w, $h);
        $bg = imagecolorallocate($img, 245, 166, 35);
        imagefill($img, 0, 0, $bg);
        ob_start();
        imagejpeg($img, null, 85);
        $binary = ob_get_clean();

        return 'data:image/jpeg;base64,' . base64_encode($binary);
    }

    private function makeGifDataUri(): string
    {
        $img = imagecreatetruecolor(8, 8);
        $bg = imagecolorallocate($img, 200, 50, 50);
        imagefill($img, 0, 0, $bg);
        ob_start();
        imagegif($img);
        $binary = ob_get_clean();

        return 'data:image/gif;base64,' . base64_encode($binary);
    }

    private function makeWebpDataUri(): string
    {
        $img = imagecreatetruecolor(8, 8);
        $bg = imagecolorallocate($img, 50, 120, 200);
        imagefill($img, 0, 0, $bg);
        if (function_exists('imagewebp')) {
            ob_start();
            imagewebp($img);
            $binary = ob_get_clean();

            return 'data:image/webp;base64,' . base64_encode($binary);
        }

        // Minimal 1x1 VP8L lossless WebP binary
        return 'data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAAAAAAfQ//73v/+BiOh/AAA=';
    }

    public function test_admin_can_upload_profile_avatar_via_jpg_and_png_data_uri_without_writing_public_dir(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Toon Burger Admin',
            'email' => 'admin-photo@example.com',
        ]);

        $avatarDir = public_path('images/avatars');
        $existingFiles = is_dir($avatarDir) ? glob($avatarDir . DIRECTORY_SEPARATOR . '*') : [];

        // 1. Upload JPEG data URI
        $jpgDataUri = $this->makeJpgDataUri();
        $resJpg = $this->actingAs($admin)->post(route('admin.profile.update'), [
            'name' => $admin->name,
            'email' => $admin->email,
            'avatar_data' => $jpgDataUri,
        ]);

        $resJpg->assertRedirect();
        $resJpg->assertSessionHas('success');
        $admin->refresh();
        $this->assertNotNull($admin->avatar);
        $this->assertStringStartsWith('data:image/jpeg;base64,', $admin->avatar);

        // 2. Upload PNG data URI and verify rendering in admin profile & header
        $pngDataUri = $this->makePngDataUri();
        $resPng = $this->actingAs($admin)->post(route('admin.profile.update'), [
            'name' => $admin->name,
            'email' => $admin->email,
            'avatar_data' => $pngDataUri,
        ]);

        $resPng->assertRedirect();
        $resPng->assertSessionHas('success');
        $admin->refresh();
        $this->assertStringStartsWith('data:image/png;base64,', $admin->avatar);

        // Profile update without avatar keeps existing Data URI avatar intact
        $resName = $this->actingAs($admin)->post(route('admin.profile.update'), [
            'name' => $admin->name . ' Updated',
            'email' => $admin->email,
        ]);
        $resName->assertSessionHas('success');

        $admin->refresh();
        $this->assertStringStartsWith('data:image/png;base64,', $admin->avatar);

        $profilePage = $this->actingAs($admin)->get(route('admin.profile'));
        $profilePage->assertOk();
        $profilePage->assertSee('src="' . $admin->avatar . '"', false);
        $profilePage->assertDontSee(asset('data:image/'), false);

        $afterFiles = is_dir($avatarDir) ? glob($avatarDir . DIRECTORY_SEPARATOR . '*') : [];
        $this->assertSame($existingFiles, $afterFiles);
    }

    public function test_admin_can_upload_profile_avatar_via_multipart_jpg_and_png_fallback(): void
    {
        $admin = User::factory()->admin()->create();

        $jpgFile = UploadedFile::fake()->image('avatar.jpg', 80, 80);
        $this->actingAs($admin)->post(route('admin.profile.update'), [
            'name' => $admin->name,
            'email' => $admin->email,
            'avatar' => $jpgFile,
        ])->assertSessionHas('success');

        $admin->refresh();
        $this->assertStringStartsWith('data:image/jpeg;base64,', $admin->avatar);

        $pngFile = UploadedFile::fake()->image('avatar.png', 80, 80);
        $this->actingAs($admin)->post(route('admin.profile.update'), [
            'name' => $admin->name,
            'email' => $admin->email,
            'avatar' => $pngFile,
        ])->assertSessionHas('success');

        $admin->refresh();
        $this->assertStringStartsWith('data:image/png;base64,', $admin->avatar);
    }

    public function test_admin_profile_rejects_non_jpg_png_uploads_and_does_not_flash_avatar_data(): void
    {
        $admin = User::factory()->admin()->create(['avatar' => 'images/avatars/existing.jpg']);

        // Reject WebP data URI
        $resWebp = $this->actingAs($admin)
            ->from(route('admin.profile'))
            ->post(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'avatar_data' => $this->makeWebpDataUri(),
            ]);
        $resWebp->assertRedirect(route('admin.profile'));
        $resWebp->assertSessionHasErrors(['avatar']);
        $this->assertArrayNotHasKey('avatar_data', session()->getOldInput());

        // Reject GIF data URI
        $resGif = $this->actingAs($admin)
            ->from(route('admin.profile'))
            ->post(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'avatar_data' => $this->makeGifDataUri(),
            ]);
        $resGif->assertRedirect(route('admin.profile'));
        $resGif->assertSessionHasErrors(['avatar']);
        $this->assertArrayNotHasKey('avatar_data', session()->getOldInput());

        // Reject garbage string
        $resBad = $this->actingAs($admin)
            ->from(route('admin.profile'))
            ->post(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'avatar_data' => 'not-an-image',
            ]);
        $resBad->assertRedirect(route('admin.profile'));
        $resBad->assertSessionHasErrors(['avatar']);
        $this->assertArrayNotHasKey('avatar_data', session()->getOldInput());

        // Reject GIF file upload
        $gifFile = UploadedFile::fake()->image('avatar.gif', 40, 40);
        $this->actingAs($admin)
            ->from(route('admin.profile'))
            ->post(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'avatar' => $gifFile,
            ])
            ->assertRedirect(route('admin.profile'))
            ->assertSessionHasErrors(['avatar']);

        // Reject WebP file upload
        $webpFile = UploadedFile::fake()->create('avatar.webp', 12, 'image/webp');
        $this->actingAs($admin)
            ->from(route('admin.profile'))
            ->post(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => $admin->email,
                'avatar' => $webpFile,
            ])
            ->assertRedirect(route('admin.profile'))
            ->assertSessionHasErrors(['avatar']);

        $admin->refresh();
        $this->assertSame('images/avatars/existing.jpg', $admin->avatar);
    }

    public function test_admin_can_create_and_update_product_with_png_and_jpg_and_render_everywhere(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->create();
        $category = Category::create([
            'name' => 'Cheese Burger',
            'slug' => 'cheese-burger',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 1. Store new product with PNG image_data
        $pngDataUri = $this->makePngDataUri(24, 24);
        $storeRes = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Special DataUri Burger',
            'category_id' => $category->id,
            'price' => 42000,
            'description' => 'Burger dengan foto data URI PNG.',
            'is_available' => 1,
            'image_data' => $pngDataUri,
        ]);

        $storeRes->assertRedirect();
        $storeRes->assertSessionHas('success');

        $product = Product::where('name', 'Special DataUri Burger')->firstOrFail();
        $this->assertStringStartsWith('data:image/png;base64,', $product->image);

        // Verify admin products view renders src cleanly and does NOT embed base64 inside openEditModal(...)
        $adminProductsPage = $this->actingAs($admin)->get(route('admin.products'));
        $adminProductsPage->assertOk();
        $adminProductsPage->assertSee('src="' . $product->image . '"', false);
        $adminProductsHtml = $adminProductsPage->getContent();
        $this->assertDoesNotMatchRegularExpression('/openEditModal\([^)]*data:image\//', $adminProductsHtml);

        // Verify public menu, product modal JSON, live search, cart add, and checkout render Data URI cleanly
        $this->get(route('menu'))
            ->assertOk()
            ->assertSee('src="' . $product->image . '"', false);

        $this->getJson(route('product.show', $product->id))
            ->assertOk()
            ->assertJsonPath('product.image_url', $product->image);

        $this->getJson(route('menu.search.live', ['q' => 'Special DataUri']))
            ->assertOk()
            ->assertJsonFragment(['image' => $product->image]);

        $cartRes = $this->actingAs($customer)->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $cartRes->assertOk()
            ->assertJsonPath('cart.items.0.image_url', $product->image);

        // Ensure cookie-backed session('cart') never holds raw base64 Data URI
        $sessionCart = session('cart', []);
        $firstCartItem = reset($sessionCart);
        $this->assertNull($firstCartItem['image'] ?? null);

        $this->actingAs($customer)
            ->get(route('orders.checkout'))
            ->assertOk()
            ->assertSee('src="' . $product->image . '"', false);

        // 2. Update product with multipart JPG fallback
        $jpgFile = UploadedFile::fake()->image('updated-burger.jpg', 100, 100);
        $updateRes = $this->actingAs($admin)->put('/admin/products/' . $product->id, [
            'name' => 'Special DataUri Burger',
            'category_id' => $category->id,
            'price' => 45000,
            'description' => 'Updated JPG',
            'is_available' => 1,
            'image' => $jpgFile,
        ]);

        $updateRes->assertRedirect();
        $updateRes->assertSessionHas('success');

        $product->refresh();
        $this->assertStringStartsWith('data:image/jpeg;base64,', $product->image);
        $this->assertSame('Updated JPG', $product->description);
    }

    public function test_admin_product_rejects_non_jpg_png_uploads_and_does_not_flash_image_data(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::create([
            'name' => 'Cheese Burger',
            'slug' => 'cheese-burger',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Original Burger',
            'slug' => 'original-burger',
            'description' => 'Original',
            'price' => 30000,
            'image' => 'images/products/beef-burger.png',
            'is_available' => true,
        ]);

        // Store rejects WebP data URI
        $storeWebp = $this->actingAs($admin)
            ->from(route('admin.products'))
            ->post(route('admin.products.store'), [
                'name' => 'Bad Product',
                'category_id' => $category->id,
                'price' => 30000,
                'image_data' => $this->makeWebpDataUri(),
            ]);
        $storeWebp->assertRedirect(route('admin.products'));
        $storeWebp->assertSessionHasErrors(['image']);
        $this->assertArrayNotHasKey('image_data', session()->getOldInput());
        $this->assertDatabaseMissing('products', ['name' => 'Bad Product']);

        // Store rejects GIF multipart file
        $gifFile = UploadedFile::fake()->image('bad.gif', 50, 50);
        $storeGif = $this->actingAs($admin)
            ->from(route('admin.products'))
            ->post(route('admin.products.store'), [
                'name' => 'Bad GIF Product',
                'category_id' => $category->id,
                'price' => 30000,
                'image' => $gifFile,
            ]);
        $storeGif->assertRedirect(route('admin.products'));
        $storeGif->assertSessionHasErrors(['image']);
        $this->assertDatabaseMissing('products', ['name' => 'Bad GIF Product']);

        // Update rejects GIF data URI and preserves original image
        $updateGif = $this->actingAs($admin)
            ->from(route('admin.products'))
            ->put('/admin/products/' . $product->id, [
                'name' => 'Original Burger',
                'category_id' => $category->id,
                'price' => 30000,
                'image_data' => $this->makeGifDataUri(),
            ]);
        $updateGif->assertRedirect(route('admin.products'));
        $updateGif->assertSessionHasErrors(['image']);
        $this->assertArrayNotHasKey('image_data', session()->getOldInput());

        // Update rejects non-image document
        $pdfFile = UploadedFile::fake()->create('menu.pdf', 20, 'application/pdf');
        $this->actingAs($admin)
            ->from(route('admin.products'))
            ->put('/admin/products/' . $product->id, [
                'name' => 'Original Burger',
                'category_id' => $category->id,
                'price' => 30000,
                'image' => $pdfFile,
            ])
            ->assertRedirect(route('admin.products'))
            ->assertSessionHasErrors(['image']);

        $product->refresh();
        $this->assertSame('images/products/beef-burger.png', $product->image);
        $this->assertStringEndsWith('/images/products/beef-burger.png', $product->image_url);
    }

    public function test_admin_can_delete_product_with_success_notification(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::create([
            'name' => 'Burger',
            'slug' => 'burger',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Deluxe Toon Burger',
            'slug' => 'deluxe-toon-burger',
            'price' => 55000,
            'is_available' => true,
        ]);

        $this->assertDatabaseHas('products', ['id' => $product->id]);

        $res = $this->actingAs($admin)
            ->from(route('admin.products'))
            ->delete(route('admin.products.delete', $product->id));

        $res->assertRedirect(route('admin.products'));
        $res->assertSessionHas('success', "Menu 'Deluxe Toon Burger' berhasil dihapus.");

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}

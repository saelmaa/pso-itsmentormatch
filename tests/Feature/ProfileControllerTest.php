<?php

namespace Tests\Feature;

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    protected ProfileController $controller;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new ProfileController();
        $this->user = new User([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
    }

    // ==================== EDIT METHOD TESTS ====================

    /**
     * Test: edit() returns profile.edit view
     */
    public function test_edit_returns_profile_edit_view(): void
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('user')
            ->willReturn($this->user);

        $result = $this->controller->edit($request);

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('profile.edit', $result->getName());
    }

    /**
     * Test: edit() passes user data to view
     */
    public function test_edit_passes_user_to_view(): void
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('user')
            ->willReturn($this->user);

        $result = $this->controller->edit($request);

        $viewData = $result->getData();
        $this->assertArrayHasKey('user', $viewData);
        $this->assertSame($this->user, $viewData['user']);
    }

    /**
     * Test: edit() user has correct attributes
     */
    public function test_edit_user_has_correct_name(): void
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('user')
            ->willReturn($this->user);

        $result = $this->controller->edit($request);
        $user = $result->getData()['user'];

        $this->assertEquals('John Doe', $user->name);
    }

    /**
     * Test: edit() user has correct email
     */
    public function test_edit_user_has_correct_email(): void
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('user')
            ->willReturn($this->user);

        $result = $this->controller->edit($request);
        $user = $result->getData()['user'];

        $this->assertEquals('john@example.com', $user->email);
    }

    /**
     * Test: edit() returns View instance
     */
    public function test_edit_returns_view_instance(): void
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('user')
            ->willReturn($this->user);

        $result = $this->controller->edit($request);

        $this->assertInstanceOf(View::class, $result);
        $this->assertNotInstanceOf(\Illuminate\Http\RedirectResponse::class, $result);
    }

    // ==================== UPDATE METHOD TESTS ====================

    /**
     * Test: update() method exists
     */
    public function test_update_method_exists(): void
    {
        $this->assertTrue(method_exists($this->controller, 'update'));
    }

    /**
     * Test: update() is public method
     */
    public function test_update_is_public_method(): void
    {
        $reflection = new \ReflectionMethod(ProfileController::class, 'update');
        $this->assertTrue($reflection->isPublic());
    }

    /**
     * Test: update() is callable
     */
    public function test_update_is_callable(): void
    {
        $this->assertTrue(is_callable([$this->controller, 'update']));
    }

    // ==================== DESTROY METHOD TESTS ====================

    /**
     * Test: destroy() method exists
     */
    public function test_destroy_method_exists(): void
    {
        $this->assertTrue(method_exists($this->controller, 'destroy'));
    }

    /**
     * Test: destroy() is public method
     */
    public function test_destroy_is_public_method(): void
    {
        $reflection = new \ReflectionMethod(ProfileController::class, 'destroy');
        $this->assertTrue($reflection->isPublic());
    }

    /**
     * Test: destroy() is callable
     */
    public function test_destroy_is_callable(): void
    {
        $this->assertTrue(is_callable([$this->controller, 'destroy']));
    }

    // ==================== CONTROLLER CLASS TESTS ====================

    /**
     * Test: ProfileController extends Controller
     */
    public function test_profile_controller_extends_controller(): void
    {
        $reflection = new \ReflectionClass(ProfileController::class);
        $parent = $reflection->getParentClass();
        
        $this->assertNotNull($parent);
        $this->assertEquals('App\Http\Controllers\Controller', $parent->getName());
    }

    /**
     * Test: ProfileController has all public methods
     */
    public function test_profile_controller_has_all_required_methods(): void
    {
        $this->assertTrue(method_exists($this->controller, 'edit'));
        $this->assertTrue(method_exists($this->controller, 'update'));
        $this->assertTrue(method_exists($this->controller, 'destroy'));
    }

    /**
     * Test: edit() view name is string
     */
    public function test_edit_view_name_is_valid(): void
    {
        $request = $this->createMock(Request::class);
        $request->method('user')->willReturn($this->user);

        $result = $this->controller->edit($request);

        $this->assertIsString($result->getName());
        $this->assertNotEmpty($result->getName());
        $this->assertStringContainsString('profile', strtolower($result->getName()));
    }

    /**
     * Test: edit() passes user instance not array
     */
    public function test_edit_passes_user_instance(): void
    {
        $request = $this->createMock(Request::class);
        $request->method('user')->willReturn($this->user);

        $result = $this->controller->edit($request);
        $user = $result->getData()['user'];

        $this->assertInstanceOf(User::class, $user);
    }
}

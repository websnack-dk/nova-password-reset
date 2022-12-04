<?php

namespace Websnack\ResetPassword;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Websnack\ResetPassword\Http\Requests\ResetPasswordRequest;

class ResetPassword extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot(): void
    {
        Nova::script('reset-password', __DIR__.'/../dist/js/tool.js');
        Nova::style('reset-password', __DIR__.'/../dist/css/tool.css');

        if (config('nova-password-reset.show_on_sidebar')) {
            Nova::userMenu(static function (Request $request, Menu $menu) {
                return $menu
                    ->prepend(MenuItem::make('Reset Password', 'reset-password'));
            });
        }
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request): mixed
    {
        if (config('nova-password-reset.show_on_profile_menu')) {
            return MenuSection::make('Reset Password')
                ->path('/reset-password')
                ->icon('key');
        }
        return null;
    }
    
    
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function resetPassword(ResetPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $user               = $request->user();
        $currentPassword    = $request->get('current_password');
        $newPassword        = $request->get('password');

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json(['message' => 'The current password is incorrect.'], 403);
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }
    
    
}

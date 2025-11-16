<?php

namespace App\Http\Controllers;

use App\Models\Cultural;
use App\Models\CulturalGallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        // If already authenticated as admin, redirect to dashboard
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return redirect()->route('admin.dashboard_admin');
        }

        // Return login view with no-cache headers to avoid browser showing cached login after auth
        return response()->view('Admin.login_admin')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }

    // Proses login admin
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $credentials['is_admin'] = 1;

        // Cek login + is_admin
        if (Auth::attempt($credentials)) {
                   // Update last login timestamp (use Auth::id() to avoid property access warnings)
                   if (Auth::check()) {
                       Log::info('Admin login: updating last_login_at for user ' . Auth::id());
                       User::where('id', Auth::id())->update(['last_login_at' => now()]);
                       Log::info('Admin login: update complete for user ' . Auth::id());
                   }
           
            $request->session()->regenerate();
            $response = redirect()->route('admin.dashboard_admin')
                ->with('success_login', [
                    'title' => 'Selamat Datang',
                    'message' => 'Anda berhasil masuk sebagai administrator.'
                ]);

            // Set a short-lived cookie to indicate admin session for client-side redirect
            // This helps when the browser navigates back to cached public pages — JS on
            // public pages will read this cookie and redirect admin users back to dashboard.
            $cookie = cookie('is_admin', '1', 60); // 60 minutes
            return $response->withCookie($cookie);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau bukan admin.',
        ]);
    }

    // Logout admin
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $response = redirect()->route('admin.login')
            ->with('success_logout', [
                'title' => 'Berhasil Keluar',
                'message' => 'Anda telah berhasil logout dari akun administrator.'
            ]);

        // Remove the is_admin cookie so public pages won't redirect after logout
        return $response->withCookie(Cookie::forget('is_admin'));
    }

    public function index()
    {
        $culturals = Cultural::with('mainImage')->get();

        $totalCultural = Cultural::count();

        // Hitung total gambar (thumbnail + gallery)
        $thumbnailCount = (int) DB::table('culturals')->whereNotNull('image')->count();
        $galleryCount = (int) DB::table('cultural_galleries')->count();
        $totalImages = $thumbnailCount + $galleryCount;

        // Get the current logged-in admin user
        $adminUser = Auth::user();

        // Get the actual last login time for the current admin user by reloading from DB
        $lastLogin = null;
        if (Auth::check()) {
            $lastLogin = User::find(Auth::id())?->last_login_at;
        }
        // Convert to local timezone for display (Garut / Indonesia Western Time)
        if ($lastLogin) {
            try {
                $latestActivity = $lastLogin->setTimezone('Asia/Jakarta')->format('d M Y H:i');
            } catch (\Throwable $e) {
                // Fallback to default formatting if timezone conversion fails
                $latestActivity = $lastLogin->format('d M Y H:i');
            }
        } else {
            $latestActivity = 'Belum login';
        }

        // Return with no-cache headers to avoid browser caching admin pages
        return response()->view('Admin.dashboard_admin', compact(
            'culturals',
            'totalCultural',
            'totalImages',
            'latestActivity',
            'adminUser'
        ))
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
    public function dashboard()
    {
        // Same no-cache protection for dashboard route
        return response()->view('Admin.dashboard_admin')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}

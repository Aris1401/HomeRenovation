<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        return view("login.client");
    }

    public function indexAdmin() {
        return view('login.admin');
    }

    // Authentification pour client -> Numero de telephone
    public function authenticate(Request $request) {
        $request->validate([
            'contact' => ['required']
        ]);

        // TODO: Verifications des erreurs ici
        // ...

        // Verifier si l'user existe
        $user = Utilisateur::where('u_contact', $request->input('contact'))->first();
        if (!$user) {
            // Creer un nouvel user
            $user = Utilisateur::create(
                [
                    'u_email' => $request->input('contact'),
                    'u_nom' => $request->input('contact'),
                    'u_prenom' => $request->input('contact'),
                    'u_mot_de_passe' => md5($request->input('contact')),
                    'u_date_de_naissance' => Carbon::now(),
                    'u_id_genre' => 1,
                    'u_contact' => $request->input('contact'),
                    'u_id_profil_utilisateur' => 2
                ]
            );
        }

        // Faire connecter l'utilisateur
        Auth::login($user);
        if (Auth::check()) {
            $request->session()->regenerate();
            return redirect()->intended(route('realisaiton'));
        }
    }

    public function authenticateAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = Utilisateur::where('u_email', $request->input('email'))->where('u_mot_de_passe', md5($request->input('password')))->first();

        if ($user) {
            Auth::login($user);

            if (Auth::check()) {
                $request->session()->regenerate();
                return redirect()->intended(route('tableau-de-bord'));
            }
        }

        return back()->withErrors(['email' => 'Email ou mot de passe invalide.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'nom' => ['required'],
            'prenom' => ['required'],
            'password' => ['required'],
            'date-naissance' => ['required'],
            'genre' => ['required'],
            'contact' => ['required', 'numeric']
        ]);

        $user = Utilisateur::create(
            [
                'u_email' => $request->input('email'),
                'u_nom' => $request->input('nom'),
                'u_prenom' => $request->input('prenom'),
                'u_mot_de_passe' => md5($request->input('password')),
                'u_date_de_naissance' => $request->input('date-naissance'),
                'u_id_genre' => $request->input('genre'),
                'u_contact' => $request->input('contact'),
                'u_id_profil_utilisateur' => 2
            ]
        );

        return redirect()->route('login');
    }
}

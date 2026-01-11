<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\UsersService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layout', ['title' => 'My Profile'])]

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $password;
    public $photo;
    public $current_photo_url;
    public $remove_photo = false;
    public $banner;
    public $current_banner_url;
    public $remove_banner = false;
    public $joined_at;
    public $roles;

    public function mount()
    {
        /** @var User $user */
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->current_photo_url = $user->photo_url;
        $this->current_banner_url = $user->banner_url;
        $this->joined_at = $user->created_at->format('F Y');
        $this->roles = $user->getRoleNames()->implode(', ');
    }

    public function updateProfile(UsersService $service)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:800'],
            'banner' => ['nullable', 'image', 'max:2048'],
        ]);

        try {
            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'phone' => $this->phone,
                'address' => $this->address,
                'remove_photo' => $this->remove_photo ? '1' : '0',
                'remove_banner' => $this->remove_banner ? '1' : '0',
            ];

            $service->updateUser($user, $updateData, $this->photo, $this->banner);

            $this->password = null;
            $this->photo = null;
            $this->banner = null;
            $this->current_photo_url = $user->fresh()->photo_url;
            $this->current_banner_url = $user->fresh()->banner_url;
            $this->remove_photo = false;
            $this->remove_banner = false;

            session()->flash('success', 'Profil berhasil diperbarui');
            return redirect()->route('profile');
        } catch (\Throwable $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.profile');
    }
}

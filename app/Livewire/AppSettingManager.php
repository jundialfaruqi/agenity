<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class AppSettingManager extends Component
{
    use WithFileUploads;

    public $app_name;
    public $login_title;
    public $login_description;
    public $app_logo;
    public $current_logo_url;
    public $remove_logo = false;

    public function mount()
    {
        Gate::authorize('setting-app');

        $setting = AppSetting::first();
        if ($setting) {
            $this->app_name = $setting->app_name;
            $this->login_title = $setting->login_title;
            $this->login_description = $setting->login_description;
            $this->current_logo_url = $setting->app_logo_url;
        }
    }

    public function updatedAppLogo()
    {
        $this->validateOnly('app_logo', [
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
    }

    public function updateSettings()
    {
        Gate::authorize('setting-app');

        try {
            $this->validate([
                'app_name' => 'required|string|max:255',
                'login_title' => 'required|string|max:255',
                'login_description' => 'required|string|max:1000',
                'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024', // Max 1MB
            ]);

            $setting = AppSetting::first() ?? new AppSetting();

            $data = [
                'app_name' => $this->app_name,
                'login_title' => $this->login_title,
                'login_description' => $this->login_description,
            ];

            if ($this->remove_logo) {
                if ($setting->app_logo) {
                    Storage::disk('public')->delete($setting->app_logo);
                }
                $data['app_logo'] = null;
            }

            if ($this->app_logo) {
                if ($setting->app_logo) {
                    Storage::disk('public')->delete($setting->app_logo);
                }
                $path = $this->app_logo->store('logo', 'public');
                $data['app_logo'] = $path;
            }

            $setting->fill($data)->save();

            $this->current_logo_url = $setting->app_logo_url;
            $this->app_logo = null;
            $this->remove_logo = false;

            $this->dispatch(
                'toast',
                message: 'Pengaturan aplikasi berhasil diperbarui!',
                type: 'success'
            );

            // Trigger reload after a short delay to allow toast to be seen
            $this->dispatch('refresh-page');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch(
                'toast',
                message: 'Gagal memperbarui pengaturan: ' . $e->getMessage(),
                type: 'error'
            );
        }
    }

    public function render()
    {
        return view('livewire.app-setting-manager');
    }
}

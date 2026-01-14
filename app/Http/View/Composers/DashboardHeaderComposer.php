<?php

namespace App\Http\View\Composers;

use App\Services\NotificationService;
use Illuminate\View\View;

class DashboardHeaderComposer
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function compose(View $view)
    {
        $notifications = $this->notificationService->getAttentionRequiredItems();
        $view->with('dashboardNotifications', $notifications);
    }
}

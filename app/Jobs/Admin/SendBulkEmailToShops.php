<?php

namespace App\Jobs\Admin;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBulkEmailToShops implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The email subject
     *
     * @var string
     */
    protected $subject;

    /**
     * The email content
     *
     * @var string
     */
    protected $content;

    /**
     * The admin user sending the email
     *
     * @var \App\Models\User
     */
    protected $admin;

    /**
     * Create a new job instance.
     *
     * @param string $subject
     * @param string $content
     * @param \App\Models\User $admin
     * @return void
     */
    public function __construct(string $subject, string $content, User $admin)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all active shops with their users
        $users = User::with('shop')
            ->where('status', 'active')
            ->orWhereNotNull('email_verified_at')
            ->whereHas('shop', function ($query) {
                $query->where('is_suspended', false);
            })
            ->get();

        foreach ($users as $user) {
            if ($user->shop && $user->email) {
                $this->sendEmailToShop($user->shop);
            }
        }
    }

    /**
     * Send email to individual shop
     *
     * @param \App\Models\Shop $shop
     * @return void
     */
    protected function sendEmailToShop(User $user)
    {
        $shop = $user->shop;

        Mail::send('emails.admin-announcement', [
            'shop' => $shop,
            'content' => $this->content,
            'admin' => $this->admin
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject($this->subject)
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });
    }
}
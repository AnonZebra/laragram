<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const MAX_LOGIN_FAIL = 5;

    /**
     * Minimum time (seconds) that users are locked out for 
     * when failing too many login attempts.
     */
    const LOCKOUT_TIME = 60;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locked_flag',
        'error_count',
        'locked_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    /**
     * Returns true, otherwise false, if this user is locked out 
     * (for preventing brute force attacks), making it 'unlocked' first 
     * if it was previously locked out and the minimum
     * lock out time has passed.
     * 
     * @return bool
     */
    public function isLockedOut(): bool {
        // check if user is currently locked out
        $lockedOut = $this->locked_flag === 1;
        if ($lockedOut) {
            // check for how long the user has been locked out
            $lockedOutSec = now()->diffInSeconds($this->locked_at);
            \Log::info($lockedOutSec);
            if ($lockedOutSec > self::LOCKOUT_TIME) {
                $this->locked_flag = 0;
                $this->error_count = 0;
                $this->save();
                $lockedOut = false;
            }
        }
        return $lockedOut;
    }

    /**
     * Returns the user with an email matching the passed one if it exists,
     * otherwise returns null.
     * 
     * @param string email
     * @return boolean
     */
    public static function getUserByEmail($email): User {
        return self::where('email', $email)->first();
    }

    /**
     * Increments the user's 'error count' (count of number of failed login attempts)
     * by 1 and, if it exceeds the maximum allowed number of failed attempts,
     * locks the user account. Returns true if user was locked out, otherwise
     * false.
     * 
     * @return boolean
     */
    public function incrementErrorCount(): bool {
        $lockedOut = false;
        $this->error_count++;
        if ($this->error_count > self::MAX_LOGIN_FAIL) {
            $this->locked_flag = 1;
            $this->locked_at = now();
            $lockedOut = true;
        }
        $this->save();
        return $lockedOut;
    }

    /**
     * Resets the user's 'error count' (count of number of failed login attempts)
     * to 0.
     * 
     * @return void
     */
    public function resetErrorCount(): void {
        $this->error_count = 0;
        $this->save();
    }
}

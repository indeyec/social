<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'first_name',
        'last_name',
        'middle_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    #получить имя и фамилию
    public function getName()
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }
        if ($this->first_name) {
            return $this->first_name;
        }

        return null;
    }

    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUsername()
    {
        return $this->first_name ?: $this->username;
    }

    public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email)?d=mm&s=50 }}";
    }

    #пользователю принадлежит статус (айдишник пользователя на статус)
    public function statuses()
    {
        return $this->hasMany('App\Models\Status', 'user_id');
    }

    #get user's likes count
    public function likes()
    {
        return $this->hasMany('App\Models\Like', 'user_id');
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
    }

    #чтобы показывалось например у user1 друг user2, а у user2 в друзьях user1
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
            ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    #запрос на ожидание друга
    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    #есть запрос на добавление в друзья
    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    #получил запрос о дружбе
    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    #добавить друга
    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    #delete friend
    public function deleteFriend(User $user)
    {
        $this->friendOf()->detach($user->id);
        $this->friendsOfMine()->detach($user->id);
    }

    #принять запрос на дружбу
    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => true
        ]);
    }

    #дружит с
    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    public function hasLikedStatus(Status $status)
    {
        return (bool) $status->likes
            ->where('likeable_id', $status->id)
            ->where('likeable_type', get_class($status))
            ->where('user_id', $this->id)
            ->count();
    }

}

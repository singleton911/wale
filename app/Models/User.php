<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use HasFactory;

    protected $guarded = ['id', 'spent', 'role', 'status', 'store_status', 'pgp_key'];
    public function store(){
        return $this->hasOne(Store::class);
    }

    public function supports(){
        return $this->hasMany(Support::class, 'user_id');
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function blockedStores(){
        return $this->hasMany(BlockStore::class);
    }

    public function favoriteStores(){
        return $this->hasMany(FavoriteStore::class);
    }

    public function favoriteListings(){
        return $this->hasMany(FavoriteListing::class);
    }

    public function referrals(){
        return $this->hasMany(Referral::class);
    }

    public function wallet(){
        return $this->hasOne(Wallet::class);
    }

    public function getAuthIdentifierName()
    {
        return 'id'; // or the name of the column that represents the primary key
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function usedPromocodes(){
        return $this->hasMany(userPromos::class);
    }

    public function waiver(){
        return $this->hasOne(Waiver::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function agency(){
        return $this->belongsTo(Agency::class);
    }

    public function invoiceDue(){
        return $this->hasMany(InvoiceDue::class,'reservation_id');
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function reservationDetail(){
        return $this->hasMany(ReservationDetail::class);
    }

    public function scopeClient($query,$clientId){
        $query->where('client_id',$clientId);
    }

    public function scopeActive($query, $active = true){
        switch($active){
            case "true":
                $active = true;
            break;
            case "false":
                $active = false;
            break;
        }
        $query->where('active',$active ? 1 : 0);
    }

    public function scopeFrom($query,$from){
        $query->whereDate('date_from',">=",$from);
    }

    public function scopeTo($query,$to){
        $query->whereDate('date_to',"<=",$to);
    }
}

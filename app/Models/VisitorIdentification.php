<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class VisitorIdentification extends Model
{
    use  HasFactory;
    protected $table='visitor_identifications';
    protected $fillable = ['lead_id','identification_type','licence_state_code','licence_number','licence_expiry_date','passport_number','passport_expiry_date','foreign_passport_number','foreign_passport_expiry_date','medicare_number','card_color','medicare_card_expiry_date','foreign_country_name','foreign_country_code','card_middle_name','identification_option','lead_id','reference_number','identification_content'];
    
  
}

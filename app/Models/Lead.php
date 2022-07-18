<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Lead\Listing\Basic;
use App\Traits\Lead\ { Methods,Relationship,Order };
class Lead extends Model
{
    use HasFactory,Basic,Methods,Relationship,Order;
	protected $primaryKey = 'lead_id';
    public function getProducts()
	{
		return $this->hasMany('App\Models\SaleProductsEnergy', 'lead_id', 'lead_id');
	}
    public function getVisitors()
	{
		return $this->hasMany('App\Models\Visitor', 'id', 'visitor_id');
	}
    public function getUtmParameters()
	{
		return $this->hasMany('App\Models\Marketing', 'lead_id', 'lead_id');
	}
    public function getConcessionInfo()
	{
		return $this->hasMany('App\Models\VisitorConcessionDetails', 'visitor_id', 'visitor_id');
	}
    public function getAffsubAddInfo()
	{
		return $this->hasMany('App\Models\Affiliate', 'user_id', 'affiliate_id');
	}
    public function getNmiMirnNumbers()
	{
		return $this->hasMany('App\Models\VisitorInformationsEnergy', 'visitor_id', 'visitor_id');
	}
    public function getIdentificationDetails()
    {
		return $this->hasMany('App\Models\VisitorIdentifications', 'lead_id', 'lead_id');
	}
    public function getConnAndBillDetails()
    {
		return $this->hasMany('App\Models\VisitorAddresses', 'id', 'connection_address_id');
	}
	public function getVisitorEmploymentDetails()
    {
		return $this->hasMany('App\Models\VisitorEmploymentDetails', 'lead_id', 'lead_id');
	}
	public function getBrowserInfo()
    {
		return $this->hasMany('App\Models\SystemInfo', 'lead_id', 'lead_id');
	}
	public function getCustomerJourneyEnergy()
	{
		return $this->hasMany('App\Models\SaleProductsEnergy', 'lead_id', 'lead_id');
	}
	public function getCustomerJourneyMobile()
	{
		return $this->hasMany('App\Models\SaleProductsMobile', 'lead_id', 'lead_id');
	}
	public function getLeadJourneyDataEnergy()
    {
		return $this->hasMany('App\Models\LeadJourneyDataEnergy', 'lead_id', 'lead_id');
	}
	public function getLeadJourneyDataMobile()
    {
		return $this->hasMany('App\Models\LeadJourneyDataMobile', 'lead_id', 'lead_id');
	}
    
    
}

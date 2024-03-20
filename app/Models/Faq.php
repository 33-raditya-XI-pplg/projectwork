<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = "tb_faq";
    protected $primaryKey = 'id_faq';
    protected $guarded = ['id_faq'];

    public function faqPage() // FK many-to-one dengan tb_page
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}

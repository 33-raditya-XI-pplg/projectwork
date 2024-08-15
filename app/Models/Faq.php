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
    protected $fillable = ['page_id', 'pertanyaan', 'jawaban', 'created_by', 'updated_by', 'status'];

    public function faqPage()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}

<!--

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class BlogKategori extends Model
// {
//     use HasFactory;


//     protected $table = 'tb_blog_kategori';
//     protected $primaryKey = 'id_blog_kategori';


//     protected $fillable = [
//         'blog_id',
//         'kategori_id',
//         'created_by',
//         'updated_by',
//     ];


//     public $timestamps = true;


//     public function blog()
//     {
//         return $this->belongsTo(Blog::class, 'blog_id');
//     }

//     public function kategori()
//     {
//         return $this->belongsTo(Kategori::class, 'kategori_id');
//     }

// }

<<<<<<< HEAD
<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use DB;
    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use App\Models\ebooks;
    
    class ebookviewController extends Controller {
        public function index(){
            // $ebooks = DB::select('select * from ebooks ');
            $ebooks = ebooks::get();
            return view('ebooks.ebook',['ebooks'=>$ebooks]);
            
        }

        public function viewEbooks()
        {
            $ebooks = ebooks::get();
            return view('ebooks.listedEbook',['books'=>$ebooks]);
        }

        public function removeEbook($id)
        {
            $ebook = ebooks::find($id);
            if ($ebook) {
                $res = $ebook->delete();
                if ($res) {
                    return back()->with('success','Ebook removed successfuly!');
                }else{
                    return back()->with('fail','Something wrong');
                }
            }else{
                return back()->with('fail','Something wrong');
            }
        }
    }
=======
<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use DB;
    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use App\Models\ebooks;
    
    class ebookviewController extends Controller {
        public function index(){
            // $ebooks = DB::select('select * from ebooks ');
            $ebooks = ebooks::get();
            return view('ebooks.ebook',['ebooks'=>$ebooks]);
            
        }

        public function viewEbooks()
        {
            $ebooks = ebooks::get();
            return view('ebooks.listedEbook',['books'=>$ebooks]);
        }

        public function removeEbook($id)
        {
            $ebook = ebooks::find($id);
            if ($ebook) {
                $res = $ebook->delete();
                if ($res) {
                    return back()->with('success','Ebook removed successfuly!');
                }else{
                    return back()->with('fail','Something wrong');
                }
            }else{
                return back()->with('fail','Something wrong');
            }
        }
    }
>>>>>>> 40566e28ea7d73aa94597f6cb825faae6f73a573
?>
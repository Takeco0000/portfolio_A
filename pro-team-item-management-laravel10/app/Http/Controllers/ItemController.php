<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Type;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }





    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $items = Item::sortable()->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->orWhere('type_id', 'like', '%' . $search . '%')
                ->orWhere('detail', 'like', '%' . $search . '%');
        })->get();
    
        return view('item.index', compact('items'));
    }
    
    /**
     * 商品登録画面を表示
     */
    public function add(Request $request)
    {
        $types = Type::all(); // Type モデルからデータを取得する必要があります
        return view('item.add', compact('types'));
    }
    /**
     * 商品登録処理
     */
    public function store(Request $request)
    {

        // バリデーション
        $request->validate([
            'name' => 'required|max:100',
            'type_id' => 'required',
            'image' => 'max:50',
        ],[
            'name.required' => '名前は必須入力です。',
            'name.max' => '名前は100文字以内で入力してください。',
            'type_id.required' => '種別は必須です。',
            'image' => 'サイズを50KB以下に変更してください。'
        ]);


        // 商品登録2
        $image = null; // デフォルトnullに設定
        if ($request->hasFile('image')) {
            $image = base64_encode(file_get_contents($request->image->getRealPath()));
        }
        Item::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'type_id' => $request->type_id,
            'detail' => $request->detail,
            'image' => $image,
        ]);

        return redirect('/items');
    }

    /**
     * 商品編集
     */
    public function edit($id)
    {
        $types = Type::all();
        $item = Item::find($id);
        return view('item.edit', compact('item', 'types'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' =>'required|max:100',
            'type_id' => 'required',
        ]);

        $item = Item::find($id);

        // アイテム状態の更新
        $itemData = [
            'name' => $request->name,
            'type_id' => $request->type_id,
            'detail' => $request->detail,
        ];
        // もし写真が更新されれば・・・
        if ($request->hasFile('image')) {
            $image = base64_encode(file_get_contents($request->image->getRealPath()));
            $itemData['image'] = $image;
        }
        $item->update($itemData);

        return redirect('/items');
    }

    /**
     * 商品削除
     */
    public function delete(Request $request)
    {
        $item = Item::find($request->id);
        $item->delete();

        return redirect('/items');
    }

    /**
     * CSV出力
     */
    public function csv()
    {
    $users = Item::select('id', 'name', 'type_id', 'detail', 'created_at', 'updated_at')->get();
    $csvHeader = ['id', '名前', '種別番号', '詳細', '作成日時', '更新日時'];
    $csvData = $users->toArray();

    $response = new StreamedResponse(function () use ($csvHeader, $csvData) {
        $handle = fopen('php://output', 'w');
        fputcsv($handle, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
    }, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="商品リスト.csv"',
    ]);

    return $response;
    }

}

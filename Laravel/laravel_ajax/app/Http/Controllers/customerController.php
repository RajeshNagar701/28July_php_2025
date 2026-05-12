<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = customer::all();
        return view('search', ['data' => $data]);
    }

    public function getcustomer($key)
    {
        $data = customer::where('name', 'LIKE', '%' . $key . '%')->orwhere('email', 'LIKE', '%' . $key . '%')->get();
?>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
        <?php
        if (!$data->isEmpty()) {
            foreach ($data as $d) {
        ?>
                <tr>
                    <td><?php echo $d->id; ?></td>
                    <td><?php echo $d->name; ?></td>
                    <td><?php echo $d->email; ?></td>
                    <td><?php echo $d->password; ?></td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="4" align="center"> No Data Found</td>
            </tr>
<?php
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

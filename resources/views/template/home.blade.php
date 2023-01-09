<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>Product</title>

    <style>
        table, th, td {
          border:1px solid black;
        }
        .container {
            display: flex;
            /* border: 1px solid blue; */
            /* align-items: center; */
        }
        .table {
            width: 90%;
            margin-left: 2rem;
            /* border: 1px solid red; */
        }
        .table table {
            width: 100%;
        }

        .table table #ttd {
            width: 120px;
        }

        .table table td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-create">
            <h2>Create Product:</h2>
            <form action="/action_page.php">
                <label for="name">name:</label><br>
                <input type="text" id="name" name="name" ><br>
                <label for="desc">description:</label><br>
                <input type="text" id="desc" name="desc" ><br>
                <label for="price">price:</label><br>
                <input type="number" min="0" id="price" name="price" ><br>
                <label for="category">category:</label><br>
                <input type="text" id="category" name="category" ><br><br>
                <input type="button" value="Create" onclick="onCreate()">
            </form> 
        </div> 
        <div class="table">
            <h2>Product Table:</h2>
            <table>
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>price</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
                @foreach ($products as $product)
                <tr>
                  <td id="tdid">{{ $product->id }}</td>
                  <td>{{ $product->p_name }}</td>
                  <td>{{ $product->p_description }}</td>
                  <td>{{ $product->p_price }}</td>
                  <td>{{ $product->p_category }}</td>
                  <td id="ttd">
                    <input type="button" value="Edit" onclick="onEdit({{$product->id}})">
                    <input type="button" value="Delete" onclick="onDelete({{$product->id}})">
                  </td>
                </tr>               
                @endforeach
              </table>
        </div>
    </div>

    <div class="form-update">
        <h2>Update Product:</h2>
        <form action="/action_page.php">
            <input type="hidden" name="" id="idEdit">
            <label for="name">name:</label><br>
            <input type="text" id="nameEdit" name="name" ><br>
            <label for="desc">description:</label><br>
            <input type="text" id="descEdit" name="desc" ><br>
            <label for="price">price:</label><br>
            <input type="number" min="0" id="priceEdit" name="price" ><br>
            <label for="category">category:</label><br>
            <input type="text" id="categoryEdit" name="category" ><br><br>
            <input type="button" value="Update" onclick="onUpdate()">
        </form> 
    </div> 

    <script>
        function onCreate() {
            // console.log('create')
            let data = {
                name: document.querySelector("#name").value,
                description: document.querySelector("#desc").value,
                price: document.querySelector("#price").value,
                category: document.querySelector("#category").value,
            }
            axios({
                url: 'api/create',
                method: 'POST',
                headers: {
                    'Content-type': 'Application/json',
                    // 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                data: data
            }).then(() => {
                alert('Created !!!')
                location.reload()
            }).catch(error => {
                alert('Error')
            })
        }

        function onEdit(id) {
            // console.log('ok')
            axios({
                url: `api/getById/${id}`,
                method: 'GET'
            }).then(response => {
                console.log(response.data.product)
                let dataObj = response.data.product
                const id = document.querySelector('#idEdit').value = dataObj.id
                const name = document.querySelector('#nameEdit').value = dataObj.p_name
                const desc = document.querySelector('#descEdit').value = dataObj.p_description
                const price = document.querySelector('#priceEdit').value = dataObj.p_price
                const category = document.querySelector('#categoryEdit').value = dataObj.p_category

            }).catch(error => {
                alert("error")
            })
        }

        function onUpdate() {
            let dataUpdate = {
                id: document.querySelector("#idEdit").value,
                name: document.querySelector("#nameEdit").value,
                description: document.querySelector("#descEdit").value,
                price: document.querySelector("#priceEdit").value,
                category: document.querySelector("#categoryEdit").value,
            }

            if (dataUpdate.name === "" && dataUpdate.description === "" && dataUpdate.price === "" && dataUpdate.category === "") {
                alert('No data')
            } else {
                axios({
                    url: 'api/update',
                    method: 'PUT',
                    headers: {
                        'Content-type': 'Application/json',
                        // 'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    data: dataUpdate,
                }).then(() => {
                    alert('Product Updated !!!')
                    location.reload()
                }).catch(error => {
                    alert('error')
                })
            }
        }

        function onDelete(id) {
            console.log('ok')
            axios({
                url: `/api/delete/${id}`,
                method: 'DELETE',
                headers: {
                    'Content-type': 'Application/json',
                }
            }).then(() => {
                alert('Deleted !!'),
                location.reload()
            }).catch(error => {
                alert('error')
            })
        }
    </script>
</body>
</html>
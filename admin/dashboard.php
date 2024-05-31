<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
          
            text-align: left;
            padding: 8px;
        }
        .btn
    {
    color:#fff;
    background-color: #fb774b;
    padding: 5px;
    border:2px solid #fb774b;
    }
    .btn:hover
    {
        background-color: #fff;
        color: #fb774b;
        transition:0.2s
    }
    </style>
</head>
<body>
    <nav>
        <div>Company Name</div>
        <form action="#">
           <a href="logout.php?logout=1" class="logout"><input type="submit" class="sign_out btn" value="Sign out" name="sign_out"></a> 
        </form>
        
    </nav>
    <aside>
        <ul>
            <li><a href="dashboard.php" class="side_bar_menu">Dashboard</a></li>
            <li><a href="#" class="side_bar_menu">Orders</a></li>
            <li><a href="#" class="side_bar_menu">Products</a></li>
            <li><a href="#" class="side_bar_menu">Customers</a></li>
            <li><a href="#" class="side_bar_menu">Create Product</a></li>
            <li><a href="#" class="side_bar_menu">Account</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="header Text">Dashboard</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
            </tr>
            <tr>
                <td>1000</td>
                <td>Random</td>
                <td>DATA</td>
                <td>data</td>
                <td>data</td>
            </tr>
            <!-- Add more rows as needed -->
        </table>
    </main>
</body>
</html>

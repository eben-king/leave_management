<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Leave</title>
</head>
<body>
<header>
      <nav>
        <ul>
          <li>
            <a href="#">
                <img src="" alt="logo">
                CKT UTAS
            </a>
          </li>
          <li>
            <img src="" alt="profile pic">
            <ul>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </header>

    <!-- Side Menu -->
    <aside>
        <nav>
            <ul>
                <li><a href="#"></a>Dashboard</li>
                <li><a href="#"></a>Profile</li>
                <li><a href="#"></a>Change Password</li>
                <li>Leave  Actions
                    <ul>
                        <li><a href="#">Request Leave</a></li>
                        <li><a href="#">Leave History</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Apply Leave Section -->
    <section>
      <h1>Update Profile</h1>
      <form action="">
        <div>
            <label for="dopl">Date Of Previous Leave</label>
            <input type="date" name="dopl" id="dopl">
        </div>
        <div>
            <label for="ol">Outstanding Leave</label>
            <input type="number" name="ol" id="ol">
        </div>
        <div>
            <label for="cl">Current Leave</label>
            <input type="number" name="cl" id="cl">
        </div>
        <div>
            <label for="tle">Total Leave Earned</label>
            <input type="number" name="tle" id="tle">
        </div>
        <div>
            <label for="ldr">Leave Days Requested</label>
            <input type="number" name="ldr" id="ldr">
        </div>
        <div>
            <label for="dlc">Date Leave Commences</label>
            <input type="date" name="dlc" id="dlc">
        </div>
        <div>
            <label for="dlc">Date Leave Ends</label>
            <input type="date" name="dlc" id="dlc">
        </div>
        <div>
            <label for="dorod">Date Of Resumption of Duty</label>
            <input type="date" name="dorod" id="dorod">
        </div>
        <input type="submit" value="UPDATE">
      </form>
    </section>

    <!-- Staff On Leave Section -->
    <section>
        <table>
            <thead>
                <th>Employee Name</th>
                <th>Leave Start Date</th>
                <th>Leave End Date</th>
            </thead>
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>Name</td>
                    <td>Name</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>
</html>
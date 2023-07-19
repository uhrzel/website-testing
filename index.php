<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <!-- Add the Bootstrap Icons library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/bootstrap-icons.min.css">
  <link rel="stylesheet" href="bootstrap-icons-1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="container">
    <div class="menu">
      <table class="class menu-container">
        <tr class="menu-row">
          <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active">
            <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
              <div>
                <p class="menu-text">Dashboard</p>
              </div>
            </a>
          </td>
        </tr>
        <tr class="menu-row">
          <td class="menu-btn">
            <a href="contact.html" class="non-style-link-menu">
              <div>
                <p class="menu-text">contact</p>
              </div>
            </a>
          </td>
        </tr>
        <tr class="menu-row">
          <td class="menu-btn">
            <a href="description.html" class="non-style-link-menu">
              <div>
                <p class="menu-text">description</p>
              </div>
            </a>
          </td>
        </tr>
        <tr class="menu-row">
          <td class="menu-btn">
            <a href="logout.html" class="non-style-link-menu">
              <div>
                <p class="menu-text">logout</p>
              </div>
            </a>
          </td>
        </tr>
      </table>
    </div>
    <div class="dash-body" style="margin-top: 15px">
      <table border="0" width="100%" style="border-spacing: 0; margin: 0; padding: 0">
        <tr>
          <td colspan="2" class="nav-bar">
            <form action="users.php" method="get" class="header-search">
              <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Users" list="doctors" />
              <input type="submit" value="Search" />
            </form>
          </td>
        </tr>
      </table>
    </div>

    <?php
    include "conn.php";

    $query = "SELECT id, username, password FROM login"; // Make sure to select 'id' as well
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      echo '<table width="93%" height="100" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
    <tr>
        <th>Username</th>
        <th>Password</th>
        <th>Actions</th>
    </tr>';

      while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $username = $row['username'];
        $password = $row['password'];

        echo '<tr>
        <td>
            <div class="cell-content">
                <span class="data username">' . $username . '</span>
            </div>
        </td>
        <td>
            <div class="cell-content">
                <span class="data password">' . $password . '</span>
            </div>
        </td>
        <td>
          <button name="edit" class="btn btn-primary edit-button" data-id="' . $id . '"><i class="bi bi-pencil-square"></i> Edit </button>
          <button name="delete" class="btn btn-danger delete-button" data-id="' . $id . '"><i class="bi bi-trash"></i> Delete </button>
        </td>
        </tr>';
      }

      echo '</table>';
    } else {
      echo "No records found.";
    }
    ?>

    <div class="modal" tabindex="-1" role="dialog" id="editModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editForm">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <input type="hidden" id="userId" name="id">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="saveButton">Save changes</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.delete-button').click(function() {
        var id = $(this).data('id');

        $.ajax({
          url: 'delete.php',
          type: 'GET',
          data: {
            'id': id
          },
          success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
              alert('Record deleted successfully');
              location.reload();
            } else {
              alert('Error deleting record');
            }
          }
        });
      });

      $('.edit-button').click(function() {
        var id = $(this).data('id');

        // Fetching the current data
        var currentUsername = $(this).closest('tr').find('.username').text();
        var currentPassword = $(this).closest('tr').find('.password').text();

        // Fill the form in the modal with the existing data
        $('#username').val(currentUsername);
        $('#password').val(currentPassword);
        $('#userId').val(id);

        // Show the modal
        $('#editModal').modal('show');
      });

      $('#saveButton').click(function() {
        var id = $('#userId').val();
        var newUsername = $('#username').val();
        var newPassword = $('#password').val();

        if (newUsername && newPassword) {
          $.ajax({
            url: 'edit.php',
            type: 'POST',
            data: {
              'id': id,
              'username': newUsername,
              'password': newPassword
            },
            success: function(response) {
              response = JSON.parse(response);
              if (response.status === 'success') {
                alert('Record edited successfully');
                location.reload();
              } else {
                alert('Error editing record');
              }
            }
          });
        } else {
          alert("Username and password cannot be empty");
        }

        // Close the modal
        $('#editModal').modal('hide');
      });
    });
  </script>
</body>

</html>
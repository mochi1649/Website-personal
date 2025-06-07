<?php
include('config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = "";

// Validasi ID
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// Ambil data pengguna
$stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    die("Pengguna tidak ditemukan.");
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if ($name && $email) {
        $stmt = $conn->prepare("UPDATE user SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $id);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal memperbarui data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Nama dan email harus diisi.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 40px;
        }

        form {
            background: #fff;
            padding: 20px;
            max-width: 400px;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<h2>Edit Pengguna</h2>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="edit.php?id=<?= htmlspecialchars($row['id']) ?>" method="post">
    <label for="name">Nama</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>

    <input type="submit" value="Update">
</form>

</body>
</html>

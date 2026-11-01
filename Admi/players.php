<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/.dependencies/main.php"; 

$userCount = $db->fetch("SELECT COUNT(*) as count FROM users")["count"];
?>
<?php 
requireLogin(); 
if (!isset($_USER)) {
    die("ok");
}
if ($_USER["role"] === "member") {
    http_response_code(404);
    header("Location: /Error/Default.aspx");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = (int)($_POST["userid"] ?? 0);
    $amount = (int)($_POST["amount"] ?? 0);
    $action = $_POST["action"] ?? "";

    $targetUser = $db->fetch(
        "SELECT id, username, robux FROM users WHERE id = ?",
        [$userId]
    );

    if (!$targetUser) {
        $message = "User not found.";
    } elseif ($action === "add") {
        $db->execute("UPDATE users SET robux = robux + ? WHERE id = ?", [$amount, $userId]);
        $message = "XORBUX added successfully.";
    } elseif ($action === "remove" && $amount > 0) {
        $db->execute("UPDATE users SET robux = GREATEST(0, robux - ?) WHERE id = ?", [$amount, $userId]);
        $message = "XORBUX removed successfully.";
    } elseif ($action === "set" && $amount >= 0) {
        $db->execute("UPDATE users SET robux = ? WHERE id = ?", [$amount, $userId]);
        $message = "XORBUX balance updated successfully.";
    } else {
        $message = "Invalid action or amount.";
    }
}
?>
<?php Component::Render("adminNav"); ?>
<title>Admin - Players</title>
<h2>Players</h2>
<p>The current amount of users registered on the site is <?= $userCount ?></p>
<h2>Manage XORBUX</h2>
<?php if (isset($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <p><label>User ID:</label><br><input type="number" name="userid" min="1" required></p>
    <p><label>Amount:</label><br><input type="number" name="amount" min="0" required></p>
    <p>
        <label>Action:</label><br>
        <select name="action" required>
            <option value="add">Add XORBUX</option>
            <option value="remove">Remove XORBUX</option>
            <option value="set">Set balance</option>
        </select>
    </p>
    <button type="submit">Update XORBUX</button>
</form>
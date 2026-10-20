<?php

require_once __DIR__ . "/config/database.php";

$id = $_GET["id"] ?? $_POST["id"] ?? null;

$id = filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range >= 1"]]);

$application = false;

if ($id !== false) {

    $sql = "SELECT * 
        FROM applications
        WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id" => $id]);

    $application = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($application === false) {
    http_response_code(404);
}

$company = "";
$position = "";
$location = "";
$status = "";
$appliedDate = "";

if ($application !== false) {
    $company = $application["company"];
    $position = $application["position"];
    $location = $application["location"];
    $status = $application["status"];
    $appliedDate = $application["applied_date"];
}

$errors = [];
$isSubmitted = false;

$statusOptions = [
    "Wishlist",
    "Applied",
    "Screening",
    "Technical Test",
    "Interview",
    "Offer",
    "Rejected",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $company = trim($_POST["company"] ?? "");
    $position = trim($_POST["position"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $status = trim($_POST["status"] ?? "");
    $appliedDate = trim($_POST["applied_date"] ?? "");

    if ($company === "") {
        $errors["company"] = "Company is required.";
    } elseif (mb_strlen($position) > 100) {
        $errors["company"] = "Company must be at most 10 characters.";
    }

    if ($position === "") {
        $errors["position"] = "Position is required.";
    } else if (mb_strlen($position) > 100) {
        $errors["position"] = "Position must be at least 100 characters.";
    }

    if ($location === "") {
        $errors["location"] = "Location is required.";
    } else if (mb_strlen($location) > 100) {
        $errors["location"] = "Location must be at least 100 characters";
    }

    if ($status === "" || !in_array($status, $statusOptions, true)) {
        $errors["status"] = "status is required.";
    }

    $date = DateTime::createFromFormat("Y-m-d", $appliedDate);
    if ($appliedDate === "") {
        $errors["applied_date"] = "Applied Date is required.";
    } else if (!$date || $date->format("Y-m-d") !== $appliedDate) {
        $errors["applied_date"] = "Applied date is not a valid date.";
    }

    if (empty($errors)) {
        $isSubmitted = true;
    }

    if (empty($errors)) {

        $sql = "UPDATE applications 
                SET 
                   company = :company;
                   position = ;position;
                   location = :location;
                   status = :status;
                   applied_date = :applied_date
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            "company" => $company,
            "position" => $position,
            "location" => $location,
            "status" => $status,
            "applied_date" => $appliedDate
        ]);

        header("Location: index.php?added=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit application</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100">
    <main class="mx-auto max-w-2xl px-4 py-10">

        <h1 class="text-3xl font-extrabold text-slate-900">Edit <?= $application["company"] ?></h1>

        <?php if ($isSubmitted): ?>
            <div class="mt-6 rounded-3xl bg-slate-900 p-6 text-white">
                <h2 class="text-xl font-bold">Application Submitted</h2>
                <dl class="mt-4 space-y-1 text-sm">
                    <div>
                        <dt class="inline text-slate-400">Company:</dt>
                        <dd class="inline"><?= htmlspecialchars($company) ?></dd>
                    </div>
                    <div>
                        <dt class="inline text-slate-400">Position:</dt>
                        <dd class="inline"><?= htmlspecialchars($position) ?></dd>
                    </div>
                    <div>
                        <dt class="inline text-slate-400">Location:</dt>
                        <dd class="inline"><?= htmlspecialchars($location) ?></dd>
                    </div>
                    <div>
                        <dt class="inline text-slate-400">Status:</dt>
                        <dd class="inline"><?= htmlspecialchars($status) ?></dd>
                    </div>
                    <div>
                        <dt class="inline text-slate-400">Applied Date:</dt>
                        <dd class="inline"><?= htmlspecialchars($appliedDate) ?></dd>
                    </div>
                </dl>
            </div>
        <?php endif; ?>

        <form method="POST" action="create.php" novalidate
            class="mt-6 space-y-5 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <label class="form-control">
                <span class="mb-1 text-sm font-semibold">Company</span>
                <input type="text" name="company" value="<?= htmlspecialchars($company) ?>" class="input input-bordered <?= isset($errors["company"]) ? "input-error" : "" ?>">
                <?php if (isset($errors["company"])): ?>
                    <span class="mt-1 text-sm text-error">
                        <?= htmlspecialchars($errors["company"]) ?>
                    </span>
                <?php endif ?>
            </label>

            <label class="form-control">
                <span class="mb-1 text-sm font-semibold">Position</span>
                <input type="text" name="position" value="<?= htmlspecialchars($position) ?>"
                    class="input input-bordered <?= isset($errors["position"]) ? "input-error" : "" ?>">
                <?php if (isset($errors["position"])): ?>
                    <span class="mt-1 text-sm text-error"><?= htmlspecialchars($errors["position"]) ?></span>
                <?php endif; ?>
            </label>

            <label class="form-control">
                <span class="mb-1 text-sm font-semibold">Location</span>
                <input type="text" name="location" value="<?= htmlspecialchars($location) ?>"
                    class="input input-bordered <?= isset($errors["location"]) ? "input-error" : "" ?>">
                <?php if (isset($errors["location"])): ?>
                    <span class="mt-1 text-sm text-error"><?= htmlspecialchars($errors["location"]) ?></span>
                <?php endif; ?>
            </label>

            <label class="form-control">
                <span class="mb-1 text-sm font-semibold">Status</span>
                <select name="status"
                    class="select select-bordered <?= isset($errors["status"]) ? "select-error" : "" ?>">
                    <option value="">-- choose status --</option>
                    <?php foreach ($statusOptions as $option): ?>
                        <option value="<?= htmlspecialchars($option) ?>" <?= $status === $option ? "selected" : "" ?>>
                            <?= htmlspecialchars($option) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors["status"])): ?>
                    <span class="mt-1 text-sm text-error"><?= htmlspecialchars($errors["status"]) ?></span>
                <?php endif; ?>
            </label>

            <label class="form-control">
                <span class="mb-1 text-sm font-semibold">Applied date</span>
                <input type="date" name="applied_date" value="<?= htmlspecialchars($appliedDate) ?>"
                    class="input input-bordered <?= isset($errors["applied_date"]) ? "input-error" : "" ?>">
                <?php if (isset($errors["applied_date"])): ?>
                    <span class="mt-1 text-sm text-error"><?= htmlspecialchars($errors["applied_date"]) ?></span>
                <?php endif; ?>
            </label>

            <div class="flex gap-2">
                <a href="show.php?id=<?= (int) $id ?>" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-neutral flex-1">Update application</button>
            </div>
        </form>

    </main>
</body>

</html>
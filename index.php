<?php

require_once __DIR__ . "/config/database.php";

$sql = "SELECT * FROM applications ORDER BY created_at DESC";

$stmt = $pdo->query($sql);


$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

function countApplications(array $applications): int
{

    $count = 0;

    foreach ($applications as $applied) {
        $count++;
    }

    return $count;
}

function countByStatus(array $applications, string $status): int
{

    $count = 0;

    foreach ($applications as $applied) {

        if ($applied["status"] === $status) {
            $count++;
        }
    }

    return $count;
}

function getStatusLabel(string $status): string
{


    if ($status === "Applied") {
        return "Application Submitted";
    } else if ($status === "Interview") {
        return "Interview Process";
    } else if ($status === "Rejected") {
        return "Not Selected";
    }


    return "Uknown";
}

$totalApplications = countApplications($applications);
$totalApplied = countByStatus($applications, "Applied");
$totalInterview = countApplications($applications, "Interview");
$totalRejected = countApplications($applications, "Rejected");

echo "JOBTRACK\n";
echo "========================================\n";

echo "Total Applications: $totalApplications \n";
echo "Applied: $totalApplied \n";
echo "Interview: $totalInterview \n";
echo "Rejected: $totalRejected \n";

echo "\n";

printf(
    "%-15s %-25s %-25s %-15s %-5s\n",
    "Company",
    "Position",
    "Status",
    "Location",
    "Applied Date"
);

echo str_repeat("-", 100) . "\n";

foreach ($applications as $app) {
    printf(
        "%-15s %-25s %-25s %-15s %-15s\n",
        $app["company"],
        $app["position"],
        getStatusLabel($app["status"]),
        $app["location"],
        $app["applied_date"],
    );
}

<?php
include '../php/config.php';
require_once('../php/db.php');

if (!isset($_COOKIE['login'])) {
    header("Location: course-search.php?error=auth_required");
    exit();
}

$course = [];
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT id, name, file_path FROM Course WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    $stmt->close();
}

if (!$course || !file_exists($course['file_path'])) {
    die("Курс не найден или файл отсутствует");
}

$content = "";
$zip = new ZipArchive;
if ($zip->open($course['file_path']) === TRUE) {
    if (($index = $zip->locateName("word/document.xml")) !== false) {
        $xmlString = $zip->getFromIndex($index);
        $xml = simplexml_load_string($xmlString);
        $xml->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        foreach ($xml->xpath('//w:p') as $paragraph) {
            $paragraphText = '';

            foreach ($paragraph->xpath('.//w:t | .//w:br') as $element) {
                if ($element->getName() == 'br') {
                    $paragraphText .= "\n";
                } else {
                    $paragraphText .= (string)$element;
                }
            }

            if (trim($paragraphText) !== '') {
                $content .= '<div class="paragraph">' 
                          . nl2br(htmlspecialchars(trim($paragraphText))) 
                          . '</div>';
            }
        }
    }
    $zip->close();
}

if (empty($content)) {
    $content = '<div class="error">Содержимое курса не найдено</div>';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($course['name']) ?> - <?= $siteConfig['title'] ?></title>
    <link rel="stylesheet" href="../css/StyleSheet.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        .course-content {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .paragraph {
            text-align: justify;
            hyphens: auto;
            text-justify: inter-word;
            line-height: 1.8;
            margin-bottom: 1.5em;
            font-size: 18px;
            text-indent: 2em;
        }

        .paragraph:first-child {
            text-indent: 0;
        }

        .paragraph br {
            content: "";
            display: block;
            margin-bottom: 0.8em;
        }

        .error {
            color: #dc3545;
            padding: 20px;
            border: 1px solid #ffe0e0;
            background: #fffafa;
        }

        @media (max-width: 1240px) {
            .container {
                width: 95%;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .course-content {
                padding: 20px;
            }
            .paragraph {
                font-size: 16px;
                line-height: 1.6;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($course['name']) ?></h1>
        
        <div class="course-content">
            <?= $content ?>
        </div>

        <div class="back-link">
            <a href="course-search.php" class="btn">Назад</a>
        </div>
    </div>
</body>
</html>
<?php
$data = [
  "@context" => "http://schema.org",
  "@type" => "Person",
  "name" => $author->full_name,
  "honorificSuffix" => $author->degrees,
  "jobTitle" => $author->title_dept_company,
  "worksFor" => $author->company,
];
$data = array_filter($data, 'strlen');
?>

<script type="application/ld+json">
<?= json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?>
</script>
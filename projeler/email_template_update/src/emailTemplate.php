<?php

class EmailTemplate {
    private $templatesPath;

    public function __construct($templatesPath) {
        $this->templatesPath = $templatesPath;
    }

    public function render($templateName, $variables = []) {
        $templatePath = $this->templatesPath . '/' . $templateName . '.html';
        if (!file_exists($templatePath)) {
            throw new Exception("Template not found: $templateName");
        }

        $templateContent = file_get_contents($templatePath);

        foreach ($variables as $key => $value) {
            $templateContent = str_replace('{{' . $key . '}}', $value, $templateContent);
        }

        return $templateContent;
    }
}
?>

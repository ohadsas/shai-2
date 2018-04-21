<?php

/* layout.html */
class __TwigTemplate_d81603868d161154077aee42292edefcef3a2a78d92ce444a3fb97a6a435c753 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'styles' => array($this, 'block_styles'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
            'scripts' => array($this, 'block_scripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    ";
        // line 4
        $this->displayBlock('head', $context, $blocks);
        // line 10
        echo "    ";
        $this->displayBlock('styles', $context, $blocks);
        // line 14
        echo "</head>
<body>
    <div class=\"navbar\">
        <div class=\"navbar-inner\">
            <a class=\"brand\" href=\"#\">Title</a>
            <ul class=\"nav\">
                <li class=\"active\"><a href=\"#\">Home</a></li>
                <li {}><a href=\"#\">Link</a></li>
                <li><a href=\"#\">Link</a></li>
            </ul>
        </div>
    </div>
    <div id=\"content\">";
        // line 26
        $this->displayBlock('content', $context, $blocks);
        echo "</div>
    <div id=\"footer\">";
        // line 27
        $this->displayBlock('footer', $context, $blocks);
        echo "</div>
    ";
        // line 28
        $this->displayBlock('scripts', $context, $blocks);
        // line 34
        echo "</body>
</html>";
    }

    // line 4
    public function block_head($context, array $blocks = array())
    {
        // line 5
        echo "        <title>AppThis-Test</title>
        <meta charset=\"UTF-8\">
        <meta name=\"robots\" content=\"noindex, nofollow\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    ";
    }

    // line 10
    public function block_styles($context, array $blocks = array())
    {
        // line 11
        echo "        <link rel=\"stylesheet\" href=\"css/bootstrap.css\" />
        <link rel=\"stylesheet\" href=\"css/bootstrap-responsive.css\" />
    ";
    }

    // line 26
    public function block_content($context, array $blocks = array())
    {
    }

    // line 27
    public function block_footer($context, array $blocks = array())
    {
    }

    // line 28
    public function block_scripts($context, array $blocks = array())
    {
        // line 29
        echo "    <script type=\"text/javascript\" src=\"js/jquery-1.11.1.js\"></script>
    <script type=\"text/javascript\" src=\"js/backbone.js\"></script>
    <script type=\"text/javascript\" src=\"js/underacore.js\"></script>
    <script type=\"text/javascript\" src=\"js/bootstrap.js\"></script>
    ";
    }

    public function getTemplateName()
    {
        return "layout.html";
    }

    public function getDebugInfo()
    {
        return array (  96 => 29,  93 => 28,  88 => 27,  83 => 26,  77 => 11,  74 => 10,  66 => 5,  63 => 4,  58 => 34,  56 => 28,  52 => 27,  48 => 26,  34 => 14,  31 => 10,  29 => 4,  24 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "layout.html", "/var/www/appthis-test/public/html/layout.html");
    }
}

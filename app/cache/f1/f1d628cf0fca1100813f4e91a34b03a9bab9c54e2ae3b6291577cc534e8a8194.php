<?php

/* publisher_view.html */
class __TwigTemplate_702349f118a3e1560272391d1fb900857f0034ed8ad56ab6cec889d7f5674865 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html", "publisher_view.html", 1);
        $this->blocks = array(
            'styles' => array($this, 'block_styles'),
            'scripts' => array($this, 'block_scripts'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_styles($context, array $blocks = array())
    {
        // line 4
        $this->displayParentBlock("styles", $context, $blocks);
        echo "
";
    }

    // line 7
    public function block_scripts($context, array $blocks = array())
    {
        // line 8
        $this->displayParentBlock("scripts", $context, $blocks);
        echo "
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "<h1>Hello, world!</h1>
";
    }

    public function getTemplateName()
    {
        return "publisher_view.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 12,  48 => 11,  42 => 8,  39 => 7,  33 => 4,  30 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "publisher_view.html", "/var/www/appthis-test/public/html/publisher_view.html");
    }
}

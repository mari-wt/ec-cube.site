<?php

/* __string_template__71313efed319c77394bf552681ee9be2f6002a4dc1dc28e6f7b1d16cfce274e4 */
class __TwigTemplate_0675183729619e5d9f59ef161b4ef83df868a6f8d0e88b869d58382fe5d42adc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 22
        $this->parent = $this->loadTemplate("default_frame.twig", "__string_template__71313efed319c77394bf552681ee9be2f6002a4dc1dc28e6f7b1d16cfce274e4", 22);
        $this->blocks = array(
            'javascript' => array($this, 'block_javascript'),
            'main' => array($this, 'block_main'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 24
        $context["body_class"] = "front_page";
        // line 22
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    public function block_javascript($context, array $blocks = array())
    {
        // line 27
        echo "<script>
\$(function(){
    \$('.main_visual').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        speed: 300
    });
});
</script>
";
    }

    // line 39
    public function block_main($context, array $blocks = array())
    {
        // line 40
        echo "    <div class=\"row\">
       <div class=\"col-sm-12\">
            <div class=\"main_visual\">
                <div class=\"item\">
                  <img src=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/top/mv01.jpg\">
                </div>
                <div class=\"item\">
                  <img src=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/top/mv02.jpg\">
                </div>
                <div class=\"item\">
                  <img src=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["app"] ?? null), "config", array()), "front_urlpath", array()), "html", null, true);
        echo "/img/top/mv03.jpg\">
                </div>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__71313efed319c77394bf552681ee9be2f6002a4dc1dc28e6f7b1d16cfce274e4";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 50,  64 => 47,  58 => 44,  52 => 40,  49 => 39,  35 => 27,  32 => 26,  28 => 22,  26 => 24,  11 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__71313efed319c77394bf552681ee9be2f6002a4dc1dc28e6f7b1d16cfce274e4", "");
    }
}

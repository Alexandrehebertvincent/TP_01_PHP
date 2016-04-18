var LoginModalController = {
    tabsElementName: ".logmod__tabs li",
    tabElementName: ".logmod__tab",
    inputElementsName: ".logmod__form .input",
    hidePasswordName: ".hide-password",

    inputElements: null,
    tabsElement: null,
    tabElement: null,
    hidePassword: null,

    activeTab: null,
    tabSelection: 0, // 0 - first, 1 - second

    findElements: function () {
        var base = this;

        base.tabsElement = $(base.tabsElementName);
        base.tabElement = $(base.tabElementName);
        base.inputElements = $(base.inputElementsName);
        base.hidePassword = $(base.hidePasswordName);

        return base;
    },

    setState: function (state) {
        var base = this,
            elem = null;

        if (!state) {
            state = 0;
        }

        if (base.tabsElement) {
            elem = $(base.tabsElement[state]);
            elem.addClass("current");
            $("." + elem.attr("data-tabtar")).addClass("show");
        }

        return base;
    },

    getActiveTab: function () {
        var base = this;

        base.tabsElement.each(function (i, el) {
            if ($(el).hasClass("current")) {
                base.activeTab = $(el);
            }
        });

        return base;
    },

    deleteWhiteSpaces: function () {
        $("input").each(function(){
            $(this).val($(this).val().trim());
        });
    },

    verifierSiNomUtilisateurValide: function () {
        var nom = $("#nouveau_nom").val();
        $.ajax({
            method: "POST",
            url: "include/verifier-nom-utilisateur.php",
            dataType: "JSON",
            data: { pseudo: nom }
        })
        .done(function( msg ) {
            if (msg["Valide"] == "0"){
                // Nom valide
                console.log("valide");
                return true;
            }else{
                // Nom non valide
                console.log("Non valide");
                return false;
            }
        });
    },

    addClickEvents: function () {
        var base = this;

        base.hidePassword.on("click", function (e) {
            var $this = $(this),
                $pwInput = $this.prev("input");

            if ($pwInput.attr("type") == "password") {
                $pwInput.attr("type", "text");
                $this.text("Cacher");
            } else {
                $pwInput.attr("type", "password");
                $this.text("Voir");
            }
        });

        base.tabsElement.on("click", function (e) {
            var targetTab = $(this).attr("data-tabtar");

            e.preventDefault();
            base.activeTab.removeClass("current");
            base.activeTab = $(this);
            base.activeTab.addClass("current");

            base.tabElement.each(function (i, el) {
                el = $(el);
                el.removeClass("show");
                if (el.hasClass(targetTab)) {
                    el.addClass("show");
                }
            });
        });

        base.inputElements.find("label").on("click", function (e) {
            var $this = $(this),
                $input = $this.next("input");

            $input.focus();
        });

        return base;
    },

    initialize: function () {
        var base = this;

        base.findElements().setState().getActiveTab().addClickEvents();
    }
};

$(document).ready(function() {
    LoginModalController.initialize();

    $(".input").focusout(function(){
        LoginModalController.deleteWhiteSpaces();
    });

    $("#nouveau_nom").focusout(function(){
        console.log($(LoginModalController.verifierSiNomUtilisateurValide()));
    });
});


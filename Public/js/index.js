var LoginModalController = {
    tabsElementName: ".logmod__tabs li",
    tabElementName: ".logmod__tab",
    inputElementsName: ".logmod__form .input",
    hidePasswordName: ".hide-password",
    estValide: false,
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
        console.log($("#nouveau_nom").val());
        $.ajax({
            method: "POST",
            url: "include/verifier-nom-utilisateur.php",
            dataType: "JSON",
            data: { pseudo: $("#nouveau_nom").val() }
        })
        .done(function( msg ) {
            if (msg["Valide"] == "0"){
                // Nom valide
                //console.log("valide");
                $("#info-nom-nouveau").css("visibility", "hidden");
                $("#nouveau_nom").removeClass("input-invalid");
                $("#nouveau_nom").next(".validee").css({
                    "visibility": "visible"
                });
                LoginModalController.estValide = true;
            }else{
                // Nom non valide
                //console.log("Non valide");
                $("#info-nom-nouveau").css({
                    "visibility": "visible"
                })
                    .html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Ce nom d\'utilisateur est déjà utilisé.');
                $("#nouveau_nom").addClass("input-invalid");
                $("#nouveau_nom").next(".validee").css({
                    "visibility": "hidden"
                });
                LoginModalController.estValide = false;
            }
        });
    },

    validate: function(){
        $("#new-user-form input").each(function(){
            if ($(this).hasClass("string")){
                if ($(this).attr("id") == "mdpR"){
                    if ($(this).val() != $("#mdp").val()){
                        $(this).next(".validee").css({
                            "visibility": "hidden"
                        });
                        $(this).addClass("input-invalid");
                        $(this).next("i").next("span").css({
                            "visibility": "visible"
                        });
                        LoginModalController.estValide = false;
                    }else{}
                }else{
                    if ($(this).val() != ""){
                        $(this).removeClass("input-invalid");
                        $(this).next("i").next("span").css({
                            "visibility": "hidden"
                        });
                        $(this).next(".validee").css({
                            "visibility": "visible"
                        });
                        LoginModalController.estValide = true;
                    }else{
                        $(this).addClass("input-invalid");
                        $(this).next("i").next("span").css({
                            "visibility": "visible"
                        });
                        $(this).next(".validee").css({
                            "visibility": "hidden"
                        });
                        LoginModalController.estValide = false;
                    }
                }
            }
        });

        console.log(LoginModalController.estValide);
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

    $("input#nouveau_nom").on("change paste keyup", function() {
        if ($("#nouveau_nom").val() != ""){
            LoginModalController.verifierSiNomUtilisateurValide();
        }
    });
    $("#submit-nouveau").on("click", function (e) {
        LoginModalController.validate();

        if (LoginModalController.estValide == false){
            e.preventDefault();
        }
    });
    $("form input").on("change paste keyup", function() {
        $(this).removeClass("input-invalid");
    });
    $("form input").focusout(function() {
        if ($(this).val() != ""){
            if ($(this).attr("id") == "mdpR"){
                if ($(this).val() != $("#mdp").val()){
                    $(this).next(".validee").css({
                        "visibility": "hidden"
                    });
                    $(this).addClass("input-invalid");
                    $(this).next("i").next("span").css({
                        "visibility": "visible"
                    });
                    LoginModalController.estValide = false;
                    return;
                }else{

                }
            }
            $(this).removeClass("input-invalid");
            $(this).next("i").next("span").css({
                "visibility": "hidden"
            });
            $(this).next(".validee").css({
                "visibility": "visible"
            });
        }else{
            $(this).next(".validee").css({
                "visibility": "hidden"
            });
        }
    });
});


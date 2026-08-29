{{-- ============================================================
SCRIPTS — PAINEL DO PALESTRANTE
============================================================= --}}

{{-- OVERLAY SCROLLBARS --}}
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>


{{-- BOOTSTRAP --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>


{{-- ADMINLTE --}}
<script src="{{ asset('dash/js/adminlte.js') }}"></script>


<script>
    (() => {
        "use strict";

        /*
        |--------------------------------------------------------------------------
        | OVERLAY SCROLLBARS
        |--------------------------------------------------------------------------
        */

        document.addEventListener("DOMContentLoaded", () => {

            const sidebarWrapper =
                document.querySelector(".sidebar-wrapper");

            const overlayScrollbars =
                window.OverlayScrollbarsGlobal?.OverlayScrollbars;

            const isMobile =
                window.innerWidth <= 992;

            if (
                sidebarWrapper &&
                overlayScrollbars &&
                !isMobile
            ) {

                overlayScrollbars(
                    sidebarWrapper,
                    {
                        scrollbars: {
                            theme: "os-theme-light",
                            autoHide: "leave",
                            clickScroll: true,
                        },
                    }
                );

            }

        });


        /*
        |--------------------------------------------------------------------------
        | TEMA
        |--------------------------------------------------------------------------
        */

        const getStoredTheme = () =>
            localStorage.getItem("theme");

        const getPreferredTheme = () => {

            const storedTheme =
                getStoredTheme();

            if (
                storedTheme === "light" ||
                storedTheme === "dark"
            ) {
                return storedTheme;
            }

            return window.matchMedia(
                "(prefers-color-scheme: dark)"
            ).matches
                ? "dark"
                : "light";

        };


        const setTheme = (theme) => {

            const resolvedTheme =
                theme === "auto"
                    ? (
                        window.matchMedia(
                            "(prefers-color-scheme: dark)"
                        ).matches
                            ? "dark"
                            : "light"
                    )
                    : theme;

            document.documentElement.setAttribute(
                "data-bs-theme",
                resolvedTheme
            );

        };


        const showActiveTheme = (
            theme,
            focus = false
        ) => {

            const themeSwitcher =
                document.querySelector("#bd-theme");

            if (!themeSwitcher) {
                return;
            }

            const selectedTheme =
                theme || "auto";

            const activeIcon =
                document.querySelector(
                    ".theme-icon-active i"
                );

            const buttons =
                document.querySelectorAll(
                    "[data-bs-theme-value]"
                );

            const activeButton =
                document.querySelector(
                    `[data-bs-theme-value="${selectedTheme}"]`
                );

            buttons.forEach((button) => {
                button.classList.remove("active");
                button.setAttribute(
                    "aria-pressed",
                    "false"
                );

                button
                    .querySelector(".bi-check-lg")
                    ?.classList.add("d-none");
            });

            if (!activeButton) {
                return;
            }

            activeButton.classList.add("active");
            activeButton.setAttribute(
                "aria-pressed",
                "true"
            );

            activeButton
                .querySelector(".bi-check-lg")
                ?.classList.remove("d-none");

            const sourceIcon =
                activeButton.querySelector(
                    "i:not(.bi-check-lg)"
                );

            if (
                activeIcon &&
                sourceIcon
            ) {
                activeIcon.className =
                    sourceIcon.className
                        .replace("me-2", "")
                        .trim();
            }

            if (focus) {
                themeSwitcher.focus();
            }

        };


        const storedTheme =
            getStoredTheme() || "auto";

        setTheme(storedTheme);


        document.addEventListener(
            "DOMContentLoaded",
            () => {

                showActiveTheme(storedTheme);

                document
                    .querySelectorAll(
                        "[data-bs-theme-value]"
                    )
                    .forEach((toggle) => {

                        toggle.addEventListener(
                            "click",
                            () => {

                                const theme =
                                    toggle.getAttribute(
                                        "data-bs-theme-value"
                                    );

                                localStorage.setItem(
                                    "theme",
                                    theme
                                );

                                setTheme(theme);
                                showActiveTheme(
                                    theme,
                                    true
                                );

                            }
                        );

                    });


                /*
                |--------------------------------------------------------------------------
                | CONFIRMAÇÃO DE LOGOUT
                |--------------------------------------------------------------------------
                */

                const logoutButtonForm =
                    document.getElementById(
                        "logout-form-btn"
                    );

                if (logoutButtonForm) {

                    logoutButtonForm.addEventListener(
                        "submit",
                        (event) => {

                            const confirmar =
                                window.confirm(
                                    "Deseja realmente sair?"
                                );

                            if (!confirmar) {
                                event.preventDefault();
                            }

                        }
                    );

                }

            }
        );


        window
            .matchMedia(
                "(prefers-color-scheme: dark)"
            )
            .addEventListener(
                "change",
                () => {

                    if (
                        getStoredTheme() === "auto" ||
                        !getStoredTheme()
                    ) {
                        setTheme("auto");
                    }

                }
            );

    })();
</script>
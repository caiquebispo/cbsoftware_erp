document.addEventListener('alpine:init', () => {
    Alpine.store('sidebar', {
        openMenus: [],

        toggleMenu(menuKey) {
            if (this.openMenus.includes(menuKey)) {
                this.openMenus = this.openMenus.filter(key => key !== menuKey);
            } else {
                this.openMenus.push(menuKey);
            }
        },

        isMenuOpen(menuKey) {
            return this.openMenus.includes(menuKey);
        },

        initActiveMenus() {
            document.querySelectorAll('[data-menu-active]').forEach(el => {
                const menuKeys = el.dataset.menuActive.split(',');
                menuKeys.forEach(key => {
                    if (key && !this.openMenus.includes(key)) {
                        this.openMenus.push(key);
                    }
                });
            });
        }
    });

    // Inicializa menus ativos quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', () => {
        Alpine.store('sidebar').initActiveMenus();
    });
});

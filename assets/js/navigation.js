document.addEventListener("DOMContentLoaded", () => {
   // Get the current URL path and query string
   const currentUrl = window.location.pathname + window.location.search;
   // Select all navigation items
   const navItems = document.querySelectorAll(".nav-item");

   // Remove all active, show, and collapsed classes from relevant elements
   document.querySelectorAll(".nav-item.active, .nav-link:not(.collapsed), .collapse.show, .collapse-item.active")
      .forEach(el => el.classList.remove("active", "show", "collapsed"));

   // Loop through each navigation item
   navItems.forEach(navItem => {
      const navLink = navItem.querySelector(".nav-link");
      const subMenu = navItem.querySelector(".collapse");
      let isActive = false;

      // If the nav item is a main link (no submenu) and matches the current URL
      if (navLink && !subMenu && navLink.href.includes(currentUrl)) {
         navItem.classList.add("active");
      }

      // Check submenu links for a match with the current URL
      navItem.querySelectorAll(".collapse-item").forEach(subLink => {
         if (subLink.href.includes(currentUrl)) {
            isActive = true;
            subLink.classList.add("active");
            // Traverse up to show parent menus and set them as active
            let parent = subLink.closest(".collapse");
            while (parent) {
               parent.classList.add("show");
               const parentNavItem = parent.closest(".nav-item");
               if (parentNavItem) {
                  parentNavItem.classList.add("active");
                  const parentNavLink = parentNavItem.querySelector(".nav-link");
                  if (parentNavLink) parentNavLink.classList.remove("collapsed");
               }
               // Move up to the next parent collapse, if any
               parent = parent.closest(".nav-item")?.closest(".collapse");
            }
         }
      });

      // If any submenu link is active, set the parent nav item as active and show submenu
      if (isActive) {
         navItem.classList.add("active");
         if (navLink) navLink.classList.remove("collapsed");
         if (subMenu) subMenu.classList.add("show");
      }
   });
});

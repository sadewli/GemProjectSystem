// My Inventory - Show Page Scripts

document.addEventListener('DOMContentLoaded', function () {
    // === TABS FUNCTIONALITY ===
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    tabLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            
            // Get target tab content ID
            const targetId = this.getAttribute('data-target');
            if (!targetId) return;

            // Remove active state from all links
            tabLinks.forEach(l => {
                l.classList.remove('active');
                l.classList.remove('border-[#2563eb]', 'text-[#2563eb]', 'font-bold');
                l.classList.add('border-transparent', 'text-slate-500', 'hover:text-slate-700', 'font-semibold');
            });

            // Add active state to clicked link
            this.classList.add('active');
            this.classList.remove('border-transparent', 'text-slate-500', 'hover:text-slate-700', 'font-semibold');
            this.classList.add('border-[#2563eb]', 'text-[#2563eb]', 'font-bold');

            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.remove('active');
            });

            // Show active tab content
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });

    // === CUSTOM DROPDOWN SELECTS ===
    const dropdownWrappers = document.querySelectorAll('.custom-select-wrapper');

    dropdownWrappers.forEach(wrapper => {
        const button = wrapper.querySelector('button');
        const items = wrapper.querySelectorAll('.dd-item');
        const selectedTextSpan = wrapper.querySelector('.selected-text');

        if (button) {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                
                // Close other open dropdowns
                dropdownWrappers.forEach(w => {
                    if (w !== wrapper) {
                        w.classList.remove('open');
                    }
                });

                // Toggle current dropdown
                wrapper.classList.toggle('open');
            });
        }

        items.forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();

                const val = this.innerText || this.textContent;

                // Update selected text span
                if (selectedTextSpan) {
                    selectedTextSpan.innerText = val;
                    selectedTextSpan.classList.remove('text-slate-400');
                    selectedTextSpan.classList.add('text-slate-800');
                }

                // Mark selected item
                items.forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');

                // Close dropdown
                wrapper.classList.remove('open');
            });
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function () {
        dropdownWrappers.forEach(wrapper => {
            wrapper.classList.remove('open');
        });
    });
});

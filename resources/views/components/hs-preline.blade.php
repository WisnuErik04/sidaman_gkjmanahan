<div>

    @push('scripts')
    <script>
        if (typeof HSSelect !== 'undefined') {
            console.log('⌛ Menjalankan HSSelect.autoInit() setelah delay');
            HSSelect.autoInit();
        } else {
            console.warn('❌ HSSelect belum tersedia');
        }
        document.addEventListener('livewire:init', () => {
            Livewire.on('reinit-hsselect', () => {
                console.log('⚡ Event diterima: reinit-hsselect');

                setTimeout(() => {
                    if (typeof HSSelect !== 'undefined') {
                        console.log('⌛ Menjalankan HSSelect.autoInit() setelah delay');
                        HSSelect.autoInit();
                    } else {
                        console.warn('❌ HSSelect belum tersedia');
                    }
                    if (typeof HSDropdown !== 'undefined') {
                        console.log('⌛ Menjalankan HSSelect.autoInit() setelah delay');
                        HSDropdown.autoInit();
                    } else {
                        console.warn('❌ HSSelect belum tersedia');
                    }
                    if (typeof HSDropdownFilter !== 'undefined') {
                        console.log('⌛ Menjalankan HSSelect.autoInit() setelah delay');
                        HSDropdownFilter.autoInit();
                    } else {
                        console.warn('❌ HSSelect belum tersedia');
                    }
                }, 500); // Delay 500ms = setengah detik
            });
        });

        // console.log(Livewire);
    </script>
@endpush

</div>
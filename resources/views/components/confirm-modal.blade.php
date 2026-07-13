<div
    x-data="{
        open: false,
        title: '',
        message: '',
        confirmLabel: 'Confirm',
        danger: true,
        formEl: null,
        handle(e) {
            this.title = e.detail.title ?? 'Are you sure?';
            this.message = e.detail.message ?? 'This action cannot be undone.';
            this.confirmLabel = e.detail.confirmLabel ?? (e.detail.danger === false ? 'Confirm' : 'Delete');
            this.danger = e.detail.danger ?? true;
            this.formEl = e.detail.form ?? null;
            this.open = true;
        },
        proceed() {
            this.open = false;
            if (this.formEl) this.formEl.submit();
        }
    }"
    @confirm-action.window="handle($event)"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4"
>
    <div x-show="open" x-transition.opacity @click="open = false"
         class="absolute inset-0 bg-black/55"></div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         role="alertdialog"
         aria-modal="true"
         :aria-label="title"
         class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl p-6">

        <div class="flex items-start gap-4">
            <div class="shrink-0 w-11 h-11 rounded-full flex items-center justify-center"
                 :class="danger ? 'bg-red-50' : 'bg-[#F1E9D7]'">
                <x-admin-icon name="alert-triangle" class="w-6 h-6" x-bind:class="danger ? 'text-red-500' : 'text-[#BF6B47]'" />
            </div>
            <div class="min-w-0">
                <h3 class="font-semibold text-gray-900" x-text="title"></h3>
                <p class="text-sm text-gray-500 mt-1" x-text="message"></p>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" @click="open = false"
                    class="px-4 py-2.5 min-h-[44px] rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">
                Cancel
            </button>
            <button type="button" @click="proceed()"
                    class="px-4 py-2.5 min-h-[44px] rounded-xl text-sm font-semibold text-white transition"
                    :class="danger ? 'bg-red-600 hover:bg-red-700' : 'bg-[#2E4636] hover:bg-[#243a2c]'"
                    x-text="confirmLabel">
            </button>
        </div>
    </div>
</div>

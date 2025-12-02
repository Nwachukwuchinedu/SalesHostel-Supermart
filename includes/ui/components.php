<?php

class UI {
    public static function button($label, $props = []) {
        $variant = $props['variant'] ?? 'default';
        $size = $props['size'] ?? 'default';
        $className = $props['class'] ?? '';
        $type = $props['type'] ?? 'button';
        $attrs = $props['attrs'] ?? '';
        $icon = $props['icon'] ?? '';
        $id = $props['id'] ?? '';

        $baseClass = "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0";
        
        $variants = [
            'default' => "bg-primary text-primary-foreground hover:bg-primary/90",
            'destructive' => "bg-destructive text-destructive-foreground hover:bg-destructive/90",
            'outline' => "border border-input bg-background hover:bg-accent hover:text-accent-foreground",
            'secondary' => "bg-secondary text-secondary-foreground hover:bg-secondary/80",
            'ghost' => "hover:bg-accent hover:text-accent-foreground",
            'link' => "text-primary underline-offset-4 hover:underline",
        ];

        $sizes = [
            'default' => "h-10 px-4 py-2",
            'sm' => "h-9 rounded-md px-3",
            'lg' => "h-11 rounded-md px-8",
            'icon' => "h-10 w-10",
        ];

        $class = "$baseClass " . ($variants[$variant] ?? $variants['default']) . " " . ($sizes[$size] ?? $sizes['default']) . " $className";

        $iconHtml = $icon ? "<i data-lucide='$icon'></i>" : "";
        
        if ($size === 'icon') {
             $content = $iconHtml;
        } else {
             $content = $iconHtml . $label;
        }

        $idAttr = $id ? "id='$id'" : "";

        return "<button type='$type' $idAttr class='$class' $attrs>$content</button>";
    }

    public static function input($props = []) {
        $className = $props['class'] ?? '';
        $type = $props['type'] ?? 'text';
        $placeholder = $props['placeholder'] ?? '';
        $value = $props['value'] ?? '';
        $name = $props['name'] ?? '';
        $id = $props['id'] ?? '';
        $required = isset($props['required']) && $props['required'] ? 'required' : '';
        $attrs = $props['attrs'] ?? '';

        $baseClass = "flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50";
        
        return "<input type='$type' name='$name' id='$id' value='$value' placeholder='$placeholder' class='$baseClass $className' $required $attrs />";
    }

    public static function label($text, $for = '', $className = '') {
        $baseClass = "text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70";
        return "<label for='$for' class='$baseClass $className'>$text</label>";
    }

    public static function card($content, $header = null, $className = '') {
        $headerHtml = '';
        if ($header) {
            $title = $header['title'] ?? '';
            $description = $header['description'] ?? '';
            $headerContent = $header['content'] ?? ''; // Custom header content
            
            $headerHtml = "<div class='flex flex-col space-y-1.5 p-6'>";
            if ($title) $headerHtml .= "<h3 class='font-semibold leading-none tracking-tight'>$title</h3>";
            if ($description) $headerHtml .= "<p class='text-sm text-muted-foreground'>$description</p>";
            if ($headerContent) $headerHtml .= $headerContent;
            $headerHtml .= "</div>";
        }

        return "
        <div class='rounded-xl border bg-card text-card-foreground shadow $className'>
            $headerHtml
            <div class='p-6 pt-0'>
                $content
            </div>
        </div>
        ";
    }

    public static function dialog($id, $title, $content, $footer = '') {
        // Simple modal implementation
        return "
        <div id='$id' class='fixed inset-0 z-50 bg-background/80 backdrop-blur-sm hidden flex items-center justify-center p-4'>
            <div class='w-full max-w-lg rounded-lg border bg-card text-card-foreground shadow-lg relative'>
                <div class='flex flex-col space-y-1.5 p-6'>
                    <h3 class='font-semibold leading-none tracking-tight'>$title</h3>
                    <button type='button' class='absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground' onclick=\"document.getElementById('$id').classList.add('hidden')\">
                        <i data-lucide='x' class='h-4 w-4'></i>
                        <span class='sr-only'>Close</span>
                    </button>
                </div>
                <div class='p-6 pt-0 max-h-[70vh] overflow-y-auto'>
                    $content
                </div>
                " . ($footer ? "<div class='flex items-center p-6 pt-0'>$footer</div>" : "") . "
            </div>
        </div>
        ";
    }

    public static function alertDialog($id, $title, $description, $confirmBtnId, $confirmText = 'Continue', $cancelText = 'Cancel') {
        return "
        <div id='$id' class='fixed inset-0 z-50 bg-background/80 backdrop-blur-sm hidden flex items-center justify-center p-4'>
            <div class='w-full max-w-[425px] rounded-lg border bg-card text-card-foreground shadow-lg relative'>
                <div class='flex flex-col space-y-2 p-6'>
                    <h3 class='font-semibold leading-none tracking-tight'>$title</h3>
                    <p class='text-sm text-muted-foreground'>$description</p>
                </div>
                <div class='flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2 p-6 pt-0'>
                    <button type='button' onclick=\"document.getElementById('$id').classList.add('hidden')\" class='inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 mt-2 sm:mt-0'>$cancelText</button>
                    <button type='button' id='$confirmBtnId' class='inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 px-4 py-2'>$confirmText</button>
                </div>
            </div>
        </div>
        ";
    }

    public static function table($headers, $bodyId = '') {
        $headerHtml = "";
        foreach ($headers as $h) {
            $class = $h['class'] ?? '';
            $text = $h['text'] ?? '';
            $headerHtml .= "<th class='h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0 $class'>$text</th>";
        }

        return "
        <div class='relative w-full overflow-auto'>
            <table class='w-full caption-bottom text-sm'>
                <thead class='[&_tr]:border-b'>
                    <tr class='border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted'>
                        $headerHtml
                    </tr>
                </thead>
                <tbody id='$bodyId' class='[&_tr:last-child]:border-0'>
                    <!-- Rows will be injected via JS -->
                </tbody>
            </table>
        </div>
        ";
    }
}
?>

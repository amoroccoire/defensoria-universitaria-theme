<?php
// Recibe los datos pasados desde el loop o el AJAX
$doc = $args['doc_data'] ?? [];
if (empty($doc)) return;
?>
<div class="flex items-start gap-10 py-5 group hover:bg-gray-50/60 rounded-xl px-3 -mx-3 transition-colors relative">
    <a href="<?php echo esc_url($doc['url_actual']); ?>" target="_blank" class="hidden sm:block flex-shrink-0 w-20 h-20 rounded-xs overflow-hidden bg-gray-100 border border-gray-200 hover:opacity-90 transition-opacity flex items-center justify-center">
        <?php if ($doc['image']) : ?>
        <img src="<?php echo esc_url($doc['image']); ?>" alt="<?php echo esc_attr($doc['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
        <?php else : ?>
        <div class="w-full h-full flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <?php endif; ?>
    </a>

    <div class="flex-grow min-w-0">
        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1 flex-wrap">
            <span class="text-green-700 font-medium">biblioteca</span>
            <?php if ($doc['category']) : ?>
            <span>›</span><span><?php echo esc_html($doc['category']); ?></span>
            <?php endif; ?>
            <?php if ($doc['year']) : ?>
            <span>›</span><span><?php echo esc_html($doc['year']); ?></span>
            <?php endif; ?>
        </div>

        <a href="<?php echo esc_url($doc['url_actual']); ?>" target="_blank" rel="noopener noreferrer" class="block w-fit">
            <h4 class="js-search-title text-lg font-medium text-blue-700 hover:underline leading-snug mb-1 line-clamp-3">
                <?php echo esc_html($doc['title']); ?>
            </h4>
        </a>

        <div class="inline-flex items-center gap-2 flex-wrap mb-1.5 cursor-pointer hover:scale-[1.02] transition-transform origin-left" 
        onclick="openDocPanel(<?php echo intval($doc['id']); ?>)" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' ')openDocPanel(<?php echo intval($doc['id']); ?>)">
            <?php if ($doc['tipo']) : ?>
            <span class="text-xs font-bold px-1.5 py-0.5 rounded-xs bg-gray-100 text-gray-600 border border-gray-200"><?php echo esc_html($doc['tipo']); ?></span>
            <?php endif; ?>
            
            <?php if ($doc['version_num']) : ?>
            <span class="text-xs font-semibold px-1.5 py-0.5 rounded-xs <?php echo $doc['tiene_hist'] ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600'; ?>">
                <?php echo esc_html($doc['version_num']); ?>
            </span>
            <?php endif; ?>

            <?php if ($doc['tiene_hist']) : ?>
            <span class="text-xs text-blue-500"><?php echo $doc['total_vers']; ?> Documentos vinculados</span>
            <?php endif; ?>
        </div>

        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
            <?php if ($doc['autor']) echo esc_html($doc['autor']) . ' · '; ?>
            <?php echo esc_html($doc['excerpt']); ?>
        </p>
    </div>
</div>
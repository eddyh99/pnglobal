<div class="page-wrapper">
    <section class="finance-blogs">
        <div class="container py-4">
                <!-- Card 1 -->
                <?php if (empty($blogpost)): ?>
                    <div class="news-card">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12 text-center text-white">
                                <h1>No Post</h1>
                            </div>
                        </div>
                    </div>
                <?php else:
                        foreach ($blogpost as $dt):
                            // Extract first <img> tag using regex
                            preg_match('/<img[^>]+src="([^"]+)"[^>]*>/i', $dt->content, $match);
                        
                            // Get image URL or fallback to default
                            $imageUrl = $match[1] ?? 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg';
                        
                            // Remove <img> tag from content
                            $cleanContent = preg_replace('/<img[^>]+>/i', '', $dt->content);
                ?>
                    <a href="<?= $dt->link ?? '#' ?>" target="_blank" class="text-decoration-none text-dark">
                        <div class="news-card">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-9">
                                    <div class="news-source-time"><?= $dt->created_at ?></div>
                                    <h5><?= $dt->title ?></h5>
                                    <p><?= strip_tags($cleanContent, '<a><p><br><b><i><strong><em>'); ?></p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <img src="<?= $imageUrl ?>" class="news-image" alt="News Image" style="height: 100px; width: auto;">
                                </div>
                            </div>
                        </div>
                    </a>
                <?php   endforeach;
                        endif
                ?>
            </div>        
    </section>
</div>

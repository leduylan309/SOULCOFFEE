<?php
/**
 * Title: Solutions — 03 Services
 * Slug: soul/solutions-services
 * Categories: soul-content
 */
$shop = esc_url(get_post_type_archive_link('soul_product') ?: home_url('/products/'));
$services = [
	[
		'id' => 'green',
		'n' => '01',
		'title' => 'Nhân xanh',
		'audience' => 'Nhà rang · Xuất khẩu',
		'body' => 'Lựa chọn nguồn cà phê theo chất lượng, mục tiêu rang và nhu cầu sản lượng, từ vùng trồng liên kết của Soul tại Tây Nguyên.',
		'specs' => [
			['Vùng trồng liên kết', 'Từ 500 ha'],
			['Sản lượng mỗi năm', '1.800–2.000 tấn'],
			['Chất lượng cao & đặc sản', '10% sản lượng'],
			['Thu hái & sơ chế', 'Công nghệ hiện đại'],
			['Canh tác', 'Sản xuất cà phê bền vững'],
		],
		'img' => '02-shop/Nhan-xanh.jpg',
		'alt' => 'Nhân xanh Fine Robusta trong lòng bàn tay',
		'link' => [$shop . '#c/ca-phe-nhan-xanh', 'Xem nhân xanh'],
		'flip' => false,
		'paper' => false,
	],
	[
		'id' => 'roast',
		'n' => '02',
		'title' => 'Cà phê rang cho HORECA',
		'audience' => 'Quán · Nhà hàng · Khách sạn',
		'body' => 'Cung cấp các dòng cà phê rang phù hợp với nhu cầu kinh doanh của quán cà phê, nhà hàng và khách sạn. Soul phát triển những lựa chọn cà phê phù hợp với menu, thiết bị và phương pháp pha chế, bao gồm HORECA Heritage, Classico (pha máy) và Bright, Bold (pha phin).',
		'specs' => [
			['Sản lượng trung bình', '20 tấn / tháng'],
			['Sản lượng tối đa', '60 tấn / tháng'],
			['Đóng gói', 'Công nghệ bán tự động'],
			['Hồ sơ & chứng từ', 'Giấy chứng nhận cơ sở đủ điều kiện an toàn thực phẩm (VSATTP), hồ sơ tự công bố sản phẩm (HSTCB), hóa đơn giá trị gia tăng (VAT) và các chứng từ liên quan theo quy định.'],
		],
		'img' => '02-shop/CA-PHE-RANG.jpg',
		'alt' => 'Fine Robusta vừa rang trong khay làm nguội',
		'link' => [$shop . '#c/ca-phe-chat-luong-cao', 'Xem dòng HORECA'],
		'flip' => true,
		'paper' => true,
	],
	[
		'id' => 'training',
		'n' => '03',
		'title' => 'Đào tạo',
		'audience' => 'Chủ quán · Đối tác kinh doanh',
		'body' => 'Đào tạo kiến thức cà phê, đánh giá cảm quan, pha chế và vận hành dành cho chủ quán và đối tác kinh doanh cà phê, do đội ngũ có chứng chỉ quốc tế thực hiện.',
		'specs' => [
			['Đánh giá nhân xanh', 'Q-Grader · CQI & SCA'],
			['Sơ chế', 'Processing Certificate'],
			['Rang', 'SCA Roaster'],
			['Pha chế', 'SCA Barista'],
		],
		'img' => '03b-why-soul/web/why-cupping.jpg',
		'alt' => 'Cà phê xay trong bát cupping',
		'link' => null,
		'flip' => false,
		'paper' => false,
	],
	[
		'id' => 'events',
		'n' => '04',
		'title' => 'Workshop & đồ uống cho sự kiện',
		'audience' => 'Doanh nghiệp · Agency',
		'body' => 'Menu đồ uống đa dạng, được Soul thiết kế theo yêu cầu, tư vấn dựa trên khoảng chi phí phù hợp với nhu cầu của doanh nghiệp và quy mô, tính chất của sự kiện. Soul còn đồng hành thiết kế các workshop về phương thức pha chế và câu chuyện cà phê để nội dung sự kiện thêm phong phú.',
		'specs' => [
			['Menu', 'Thiết kế theo yêu cầu'],
			['Chi phí', 'Tư vấn theo ngân sách'],
			['Workshop', 'Pha chế · Câu chuyện cà phê'],
		],
		'img' => '03b-why-soul/web/why-fine-robusta.jpg',
		'alt' => 'Barista Soul cầm tách Fine Robusta',
		'link' => null,
		'flip' => true,
		'paper' => true,
	],
	[
		'id' => 'gifts',
		'n' => '05',
		'title' => 'Combo quà tặng',
		'audience' => 'Doanh nghiệp · Cá nhân',
		'body' => 'Chuyện về vùng đất Tây Nguyên giàu bản sắc: đất đỏ phù sa, tâm hồn người con bản xứ và hơi thở văn hóa bản địa. Các combo được thiết kế vừa vặn, tiện lợi với nhiều mức giá, là lựa chọn tinh tế cho dịp đặc biệt hay làm quà cho người thân, bạn bè, đối tác. Mỗi sản phẩm bên trong đều được Soul tỉ mỉ chọn lựa.',
		'specs' => [
			['Chủ đề', 'Vùng đất · Con người · Văn hóa bản địa'],
			['Mức giá', 'Nhiều lựa chọn'],
			['Tùy chỉnh', 'Theo số lượng doanh nghiệp'],
		],
		'img' => '04-soulful/Soulful_vuong.png',
		'alt' => 'Bộ sưu tập Soulful 2026 trên gỗ lũa',
		'link' => [$shop . '#c/hop-qua-combo', 'Xem hộp quà'],
		'flip' => false,
		'paper' => false,
	],
];
?>
<!-- wp:group {"align":"full","className":"s-sol-sv is-style-surface-paper","anchor":"services","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-sol-sv is-style-surface-paper" id="services"><!-- wp:columns {"className":"s-sol-head"} -->
<div class="wp-block-columns s-sol-head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-sol-eye"} -->
<p class="s-sol-eye">Giải pháp</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-sol-h2"} -->
<h2 class="wp-block-heading s-sol-h2">Năm cách Soul đồng hành</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-sol-p"} -->
<p class="s-sol-p">Mỗi đối tác có nhu cầu khác nhau. Soul tư vấn dựa trên chất lượng mong muốn, thiết bị, quy mô và ngân sách của bạn.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"s-sol-sv__stack","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-sv__stack">
<?php foreach ($services as $s) :
	$card_class = 's-sol-sv__card';
	if ($s['paper']) {
		$card_class .= ' s-sol-sv__card--paper';
	}
	if ($s['flip']) {
		$card_class .= ' s-sol-sv__card--flip';
	}
	?>
<!-- wp:columns {"className":"<?php echo esc_attr($card_class); ?>","anchor":"<?php echo esc_attr($s['id']); ?>"} -->
<div class="wp-block-columns <?php echo esc_attr($card_class); ?>" id="<?php echo esc_attr($s['id']); ?>"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-sol-sv__media"} -->
<figure class="wp-block-image size-full s-sol-sv__media"><img src="<?php echo esc_url(soul_img($s['img'])); ?>" alt="<?php echo esc_attr($s['alt']); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-sol-sv__copy","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-sv__copy"><!-- wp:group {"className":"s-sol-sv__meta","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-sv__meta"><!-- wp:paragraph -->
<p><?php echo esc_html($s['n']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-sol-muted"} -->
<p class="s-sol-muted"><?php echo esc_html($s['audience']); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"s-sol-sv__title"} -->
<h3 class="wp-block-heading s-sol-sv__title"><?php echo esc_html($s['title']); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-sol-sv__body"} -->
<p class="s-sol-sv__body"><?php echo esc_html($s['body']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-sol-sv__specs","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-sv__specs">
<?php foreach ($s['specs'] as $sp) : ?>
<!-- wp:group {"className":"s-sol-sv__spec","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-sv__spec"><!-- wp:paragraph {"className":"s-sol-sv__spec-k"} -->
<p class="s-sol-sv__spec-k"><?php echo esc_html($sp[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-sol-sv__spec-v"} -->
<p class="s-sol-sv__spec-v"><?php echo esc_html($sp[1]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"s-sol-sv__links"} -->
<p class="s-sol-sv__links"><a href="#contact">Trao đổi về giải pháp này ↗</a><?php if ($s['link']) : ?> <a class="s-sol-sv__shop" href="<?php echo esc_url($s['link'][0]); ?>"><?php echo esc_html($s['link'][1]); ?> ↗</a><?php endif; ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->

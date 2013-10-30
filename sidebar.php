<div id="sideArea">

<?php
$url = $_SERVER['REQUEST_URI'];
$parent_slug = next(explode('/', $url));
//var_dump ($parent_slug);

if (is_home()) : //ホームページの場合?>


<?php elseif (is_page(array('hp')) || $parent_slug == 'hp' || $parent_slug == 'past_results' || $parent_slug == 'additional_functions' || $parent_slug == 'industry_type') : //ホームページ作成 ?>

	<aside class="subMenu hpMenu">
		<h3><a href="/hp/"><img src="/images/common/hpMenuTitle.png" alt="Webサイト制作" /></a></h3>
		<ul>
			<li><a href="/hp/service/">サービス紹介</a></li>
			<li><a href="/hp/flow/">ホームページ作成の流れ</a></li>
			<li><a href="/hp/price/">制作料金</a></li>
			<li><a href="/past_results/">制作実績</a></li>
			<li><a href="/hp/server/">レンタルサーバー</a></li>
			<li><a href="/hp/faq/">よくある質問</a></li>
		</ul>
	</aside>


<?php elseif (is_page(array('system')) || $parent_slug == 'system') : //ホームページ作成 ?>

	<aside class="subMenu systemMenu">
		<h3><a href="/system/"><img src="/images/common/systemMenuTitle.png" alt="システム開発" /></a></h3>
		<ul>
			<li><a href="/system/cc/">クリック・クリエイター</a></li>
			<li>
				<a class="soon">開発実績</a>
				<ul>
					<li><a class="soon">メール配信システム</a></li>
					<li><a class="soon">参集システム</a></li>
				</ul>
			</li>
			<li><a class="soon">開発の流れ</a></li>
		</ul>
<?php /*
		<ul>
			<li>
				<a href="/system/results/">開発実績</a>
				<ul>
					<li><a href="/system/results/cc/">クリッククリエイター</a></li>
					<li><a href="/system/results/mail-delivery/">メール配信システム</a></li>
					<li><a href="/system/results/gathering/">参集システム</a></li>
				</ul>
			</li>
			<li><a href="/system/sys-flow/">開発の流れ</a></li>
		</ul>
*/ ?>
	</aside>


<?php elseif (is_page(array('instructor')) || $parent_slug == 'instructor') : // インストラクター?>
<?php
/*
	<aside class="subMenu schoolMenu">
		<h3><a href="/instructor/"><img src="/images/common/instructorMenuTitle.png" alt="インストラクター" /></a></h3>
		<ul>
			<li><a href="/instructor/profile/">講師について</a></li>
			<li>
				<a href="/instructor/dispatch/">インストラクター派遣</a>
				<ul>
					<li><a href="/instructor/dispatch/results/">派遣実績</a></li>
				</ul>
			</li>
		</ul>
	</aside>
*/
?>

<?php elseif (is_page(array('corporate')) || $parent_slug == 'corporate' || $parent_slug == 'news_release' || $parent_slug == 'news_type' || $parent_slug == 'contact' || $parent_slug == 'other-works') : //会社情報 ?>

	<aside class="subMenu corpMenu">
		<h3><a href="/corporate/"><img src="/images/common/corpMenuTitle.png" alt="会社情報" /></a></h3>
		<ul>
			<li><a href="/corporate/abouts/">会社概要</a></li>
			<li><a href="/corporate/recruit/">採用情報</a></li>
			<li><a href="/corporate/isms/">ISMSについて</a></li>
			<li><a href="/corporate/access/">アクセスマップ</a></li>
			<li><a href="/corporate/privacy/">プライバシーポリシー</a></li>
			<li><a href="/contact/">お問い合わせ</a></li>
			<li><a href="/other-works/">その他の業務</a></li>
		</ul>
	</aside>

<?php elseif ($parent_slug == 'news_release') : //news & topics ?>


	<aside class="subMenu">
		<h3>News &amp; Topics</h3>
		<ul>
			<?php wp_get_archives(); ?>
		</ul>
	</aside>


<?php else : ?>



<?php endif; ?>

	<section id="aboutBox">
		<header>
			<h2 class="tit01">会社概要</h2>
			<p class="moreLink"><a href="/corporate/abouts/">詳細</a></p>
		</header>
		<dl>
		 	<dt>有限会社オフィスタグ</dt>
		 	<dd class="address">
		 		<p>〒411-0943<br />
					静岡県駿東郡長泉町下土狩217-1<br />
					渡辺ビル102 <a href="/corporate/access/">&gt; アクセスマップ</a>
				</p>
				<p class="mt5"><a class="mcolor" href="/corporate/privacy/">プライバシーポリシー</a></p>
		 	</dd>
		</dl>
		<div class="fb-like-box" data-href="http://www.facebook.com/officetug2" data-width="220" data-height="95" data-show-faces="false" data-stream="true" data-border-color="#ccc" data-header="true"></div>
		<div id="sideContact"><a href="/contact/"><img src="/images/common/lblContact.png" alt="お問い合わせ" /></a></div>

	</section>


</div>
<!-- /#rightSide -->

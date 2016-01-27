<?php 
	$sliderButtonText = "READ MORE";
	$sliderImageRoot = '/img/demo/1200x800/' . ((isset($debug) && $debug) ? 'dev' : 'prod'); 
?>

			<!-- REVOLUTION SLIDER -->
			<section id="slider" class="fullwidthbanner-container roundedcorners">
				<div class="fullscreenbanner" data-navigationStyle="">
					<ul class="hide">

						<?php if (isset($kbase) && $kbase != null) : ?>
						<?php foreach($kbase as $rec) : ?>
						<?php if ($rec['category']['nickname'] == 'slider') : ?>
						
						<!-- SLIDER PANEL -->
						<li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off" data-title="<?php echo $rec['title']; ?>" data-thumb="">

							<img src="/img/1x1.png" data-lazyload="<?php echo $sliderImageRoot . '/' . $rec['image']; ?>" alt="" data-bgfit="cover" data-bgposition="center bottom" data-bgrepeat="no-repeat" />

							<div class="overlay dark-4"><!-- dark overlay [1 to 9 opacity] --></div>

							<div class="tp-caption customin ltl text_white"
								data-x="center"
								data-y="180"
								data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
								data-speed="800"
								data-start="1000"
								data-easing="easeOutQuad"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.01"
								data-endelementdelay="0.1"
								data-endspeed="1000"
								data-endeasing="Power4.easeIn" style="z-index: 10;">
								<span class="weight-300"><?php echo $rec['subtitle'] ?></span>
							</div>

							<div class="tp-caption customin ltl tp-resizeme large_bold_white"
								data-x="center"
								data-y="230"
								data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
								data-speed="800"
								data-start="1200"
								data-easing="easeOutQuad"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.01"
								data-endelementdelay="0.1"
								data-endspeed="1000"
								data-endeasing="Power4.easeIn" style="z-index: 10;">
								<?php echo $rec['title'] ?>
							</div>

							<div class="tp-caption customin ltl text_white"
								data-x="center"
								data-y="350"
								data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
								data-speed="800"
								data-start="1400"
								data-easing="easeOutQuad"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.01"
								data-endelementdelay="0.1"
								data-endspeed="1000"
								data-endeasing="Power4.easeIn" style="z-index: 10; width: 750px; max-width: 750px; white-space: normal; text-align:center;">
								<?php echo $rec['description'] ?>
							</div>

							<div class="tp-caption customin ltl"
								data-x="center"
								data-y="438"
								data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
								data-speed="800"
								data-start="1550"
								data-easing="easeOutQuad"
								data-splitin="none"
								data-splitout="none"
								data-elementdelay="0.01"
								data-endelementdelay="0.1"
								data-endspeed="1000"
								data-endeasing="Power4.easeIn" style="z-index: 10;">
								<a 
									class="btn btn-default btn-lg"
									href="<?php echo $rec['url'] ?>" 
								>
									<span><?php echo $sliderButtonText; ?></span> 
								</a>
							</div>

						</li>
						
						<?php endif; ?>
						<?php endforeach; ?>
						<?php endif; ?>
						
					</ul>
				</div>
			</section>
			<!-- /REVOLUTION SLIDER -->

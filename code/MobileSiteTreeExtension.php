<?php
/**
 * @package mobile
 */
class MobileSiteTreeExtension extends DataExtension {
	public function MetaTags(&$tags) {
		$config = SiteConfig::current_site_config();
		// Ensure a canonical link is placed, for semantic correctness and SEO
		if (Controller::has_curr() && Controller::curr()->hasMethod("onMobileDomain") && Controller::curr()->onMobileDomain() && $config->MobileSiteType == 'RedirectToDomain') {
			$oldBaseURL = Director::baseURL();
			$fullSiteDomain = $config->FullSiteDomain;
			if(substr($fullSiteDomain,0,4) != "http") {
				$fullSiteDomain = "http://$fullSiteDomain";
			}
			Config::inst()->update('Director', 'alternate_base_url', $fullSiteDomain);
			$tags .= sprintf('<link rel="canonical" href="%s" />', $this->owner->AbsoluteLink()) . "\n";
			Config::inst()->update('Director', 'alternate_base_url', $oldBaseURL);
		}
	}
}
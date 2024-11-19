<?php

namespace Aws\MailManager;

use Aws\AwsClient;

/**
 * This client is used to interact with the **MailManager** service.
 * @method \Aws\Result createAddonInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createAddonInstanceAsync(array $args = [])
 * @method \Aws\Result createAddonSubscription(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createAddonSubscriptionAsync(array $args = [])
 * @method \Aws\Result createArchive(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createArchiveAsync(array $args = [])
 * @method \Aws\Result createIngressPoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createIngressPointAsync(array $args = [])
 * @method \Aws\Result createRelay(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createRelayAsync(array $args = [])
 * @method \Aws\Result createRuleSet(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createRuleSetAsync(array $args = [])
 * @method \Aws\Result createTrafficPolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createTrafficPolicyAsync(array $args = [])
 * @method \Aws\Result deleteAddonInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteAddonInstanceAsync(array $args = [])
 * @method \Aws\Result deleteAddonSubscription(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteAddonSubscriptionAsync(array $args = [])
 * @method \Aws\Result deleteArchive(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteArchiveAsync(array $args = [])
 * @method \Aws\Result deleteIngressPoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteIngressPointAsync(array $args = [])
 * @method \Aws\Result deleteRelay(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteRelayAsync(array $args = [])
 * @method \Aws\Result deleteRuleSet(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteRuleSetAsync(array $args = [])
 * @method \Aws\Result deleteTrafficPolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteTrafficPolicyAsync(array $args = [])
 * @method \Aws\Result getAddonInstance(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getAddonInstanceAsync(array $args = [])
 * @method \Aws\Result getAddonSubscription(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getAddonSubscriptionAsync(array $args = [])
 * @method \Aws\Result getArchive(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getArchiveAsync(array $args = [])
 * @method \Aws\Result getArchiveExport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getArchiveExportAsync(array $args = [])
 * @method \Aws\Result getArchiveMessage(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getArchiveMessageAsync(array $args = [])
 * @method \Aws\Result getArchiveMessageContent(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getArchiveMessageContentAsync(array $args = [])
 * @method \Aws\Result getArchiveSearch(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getArchiveSearchAsync(array $args = [])
 * @method \Aws\Result getArchiveSearchResults(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getArchiveSearchResultsAsync(array $args = [])
 * @method \Aws\Result getIngressPoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getIngressPointAsync(array $args = [])
 * @method \Aws\Result getRelay(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getRelayAsync(array $args = [])
 * @method \Aws\Result getRuleSet(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getRuleSetAsync(array $args = [])
 * @method \Aws\Result getTrafficPolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getTrafficPolicyAsync(array $args = [])
 * @method \Aws\Result listAddonInstances(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listAddonInstancesAsync(array $args = [])
 * @method \Aws\Result listAddonSubscriptions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listAddonSubscriptionsAsync(array $args = [])
 * @method \Aws\Result listArchiveExports(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listArchiveExportsAsync(array $args = [])
 * @method \Aws\Result listArchiveSearches(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listArchiveSearchesAsync(array $args = [])
 * @method \Aws\Result listArchives(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listArchivesAsync(array $args = [])
 * @method \Aws\Result listIngressPoints(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listIngressPointsAsync(array $args = [])
 * @method \Aws\Result listRelays(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listRelaysAsync(array $args = [])
 * @method \Aws\Result listRuleSets(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listRuleSetsAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result listTrafficPolicies(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTrafficPoliciesAsync(array $args = [])
 * @method \Aws\Result startArchiveExport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startArchiveExportAsync(array $args = [])
 * @method \Aws\Result startArchiveSearch(array $args = [])
 * @method \GuzzleHttp\Promise\Promise startArchiveSearchAsync(array $args = [])
 * @method \Aws\Result stopArchiveExport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopArchiveExportAsync(array $args = [])
 * @method \Aws\Result stopArchiveSearch(array $args = [])
 * @method \GuzzleHttp\Promise\Promise stopArchiveSearchAsync(array $args = [])
 * @method \Aws\Result tagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \Aws\Result untagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 * @method \Aws\Result updateArchive(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateArchiveAsync(array $args = [])
 * @method \Aws\Result updateIngressPoint(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateIngressPointAsync(array $args = [])
 * @method \Aws\Result updateRelay(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateRelayAsync(array $args = [])
 * @method \Aws\Result updateRuleSet(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateRuleSetAsync(array $args = [])
 * @method \Aws\Result updateTrafficPolicy(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateTrafficPolicyAsync(array $args = [])
 */
class MailManagerClient extends AwsClient
{
}

/*!
 * Matomo - free/libre analytics platform
 *
 * Screenshot test for SecurityInfo main page.
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

describe("RebelMetrics", function () {
  this.timeout(0);

  it('should load rebelmetrics page correctly', async function () {
      await page.goto("?date=yesterday&module=RebelMetrics&format=html&action=&idSite=1&period=day&segment=&widget=&showtitle=1");
      expect(await page.screenshotSelector('#rebelHeader')).to.matchImage('rebel_header');
  });
});

<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 *
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class UserMade700Comments extends Achievement
{
    /*
     * The achievement name
     */
    public $name = '700Comments';

    /*
     * A small description for the achievement
     */
    public $description = 'Wow! You have already made 700 comments!';

    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 700;
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Client\Provider\GenericProvider;
use RLaurindo\TelegramLogger\Services\TelegramService;

class OAuthController extends Controller
{
    public function index()
    {

        $employeeProvider = new GenericProvider([
            'clientId' => '177',
            'clientSecret' => '7mSJdZnxkUB0BhLtHy4mkJOk2unWo6UU',
            'redirectUri' => 'http://localhost:63342/hemis-oauth-main/web/index.php',
            'urlAuthorize' => 'https://student.ubtuit.uz/oauth/authorize',
            'urlAccessToken' => 'https://student.ubtuit.uz/oauth/access-token',
            'urlResourceOwnerDetails' => 'https://student.ubtuit.uz/oauth/api/user?fields=id,uuid,type,name,login,picture,email,university_id,phone,groups'
        ]);


// If we don't have an authorization code then get one
        if (!isset($_GET['code'])) {
            if (isset($_GET['start'])) {
                // Fetch the authorization URL from the provider; this returns the
                // urlAuthorize option and generates and applies any necessary parameters
                // (e.g. state).
                $authorizationUrl = $employeeProvider->getAuthorizationUrl();

                // Get the state generated for you and store it to the session.
                $_SESSION['oauth2state'] = $employeeProvider->getState();

                // Redirect the user to the authorization URL.
                header('Location: ' . $authorizationUrl);
                exit;
            } else {
                echo "<a href='oauth/?start=1'>Authorize with HEMIS</a>";
            }
// Check given state against previously stored one to mitigate CSRF attack
        } else if (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

            if (isset($_SESSION['oauth2state'])) {
                unset($_SESSION['oauth2state']);
            }

            exit('Invalid state');

        } else {
            try {
                // Try to get an access token using the authorization code grant.
                $accessToken = $employeeProvider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);

                // We have an access token, which we may use in authenticated
                // requests against the service provider's API.
                echo "<p>Access Token: <b>{$accessToken->getToken()}</b></p>";
                echo "<p>Refresh Token: <b>{$accessToken->getRefreshToken()}</b></p>";
                echo "Expired in: <b>" . date('m/d/Y H:i:s', $accessToken->getExpires()) . "</b></p>";
                echo "Already expired: <b>" . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "</b></p>";

                // Using the access token, we may look up details about the
                // resource owner.
                $resourceOwner = $employeeProvider->getResourceOwner($accessToken);

                echo "<pre>" . print_r($resourceOwner->toArray(), true) . "</pre>";

            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                // Failed to get the access token or user details.
                exit($e->getMessage());
            }
        }
    }
    public function callback(Request $request){
        Log::info((string)json_encode($request->all()));

    }
}

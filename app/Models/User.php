<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Permissions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    // use HasProfilePhoto;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'phone',
        'role_type',
        'password',
        'google_id',
        'facebook_id',
        'image',
        'banner_image',
        'access_level',
        'is_staff_memeber',
        'staff_member_location',
        'last_login',
        'available_in_online_booking',
        'calendar_color'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

     /**
     * Method getNameAttribute
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        $name = '';

        if( $this->first_name )
        {
            $name = $this->first_name;
        }

        if( $this->last_name )
        {
            $name .= " ".$this->last_name;
        }

        return $name;
    }

    /**
     * Get the staff_location that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff_location(): BelongsTo
    {
        return $this->belongsTo(Locations::class, 'staff_member_location', 'id');
    }
    // public function checkPermission($module){
    //     // to get modules from Permission table
    //     if($this->role_type == "admin"){
    //         return true;
    //     }else{
    //         $userId = Auth::id();
    //         $user = User::where('id',$userId)->first();

    //         $accessLevel = strtolower($user->access_level);
    //         // dd($accessLevel);
    //         if (substr($accessLevel, -1) == 's') {
    //             $accessLevel = substr($accessLevel, 0, -1);
    //         }
    //         $permissions = Permissions::where('name', $module)->get();
    //         foreach ($permissions as $permission) {
    //             // dd($permission);
    //             if ($accessLevel == 'target' && isset($permission->targets) && $permission->targets == 1) {
    //                 // dd($permission->sub_name);
    //                 // if($permission->sub_name == 'Client - View Only')
    //                 // {
    //                 //     return true;
    //                 // }else if($permission->sub_name == 'Client - View & Make Changes')
    //                 // {
    //                 //     return true;
    //                 // }
    //                 return true;
    //             } else if ($accessLevel == 'limited' && isset($permission->limited) && $permission->limited == 1) {
    //                 return true;
    //             } else if ($accessLevel == 'standard' && isset($permission->standard) && $permission->standard == 1) {
    //                 return true;
    //             } else if ($accessLevel == 'standard+' && isset($permission->standardplus) && $permission->standardplus == 1) {
    //                 return true;
    //             } else if ($accessLevel == 'advance' && isset($permission->advance) && $permission->advance == 1) {
    //                 return true;
    //             } else if ($accessLevel == 'advance+' && isset($permission->advanceplus) && $permission->advanceplus == 1) {
    //                 return true;
    //             } else if ($accessLevel == 'admin' && isset($permission->admin) && $permission->admin == 1) {
    //                 return true;
    //             } else if ($accessLevel == 'account' && isset($permission->account) && $permission->account == 1) {
    //                 return true;
    //             }
    //         }
    //         return false; // Return false if no matching permission is found
    //     }
    // }
    // public function checkPermission($module)
    // {
    //     // If the user is an admin, grant permission
    //     if ($this->role_type == "admin") {
    //         return true;
    //     } else {
    //         // Normalize access level
    //         $userId = Auth::id();
    //         $user = User::where('id',$userId)->first();

    //         $accessLevel = strtolower($this->access_level);
    //         // Fetch permissions for the specified module
    //         $permissions = Permissions::where('name', $module)->get();
    //         // dd($permissions);
    //         if ($permissions->isEmpty()) {
    //             return false; // No permission found for the module
    //         }

    //         $viewOnlyPermission = $permissions->where('sub_name', 'Client - View Only')->first();
    //         // dd($viewOnlyPermission);
    //         $viewAndChangesPermission = $permissions->where('sub_name', 'Client - View & Make Changes')->first();
    //         // dd($accessLevel);
    //         if ($accessLevel == 'targets' && $viewOnlyPermission && $viewOnlyPermission->targets == 1) {
    //             if ($viewAndChangesPermission && $viewAndChangesPermission->targets == 1) {
    //                 return 'Both';
    //             } else {
    //                 return 'Client - View Only';
    //             }
    //         }else if ($accessLevel == 'limited' && $viewOnlyPermission && $viewOnlyPermission->limited == 1) {
    //             if ($viewAndChangesPermission && $viewAndChangesPermission->limited == 1) {
    //                 return 'Both';
    //             } else {
    //                 return 'Client - View Only';
    //             }
    //         }else if ($accessLevel == 'standard' && $viewOnlyPermission && $viewOnlyPermission->standard == 1) {
    //             if ($viewAndChangesPermission && $viewAndChangesPermission->standard == 1) {
    //                 return 'Both';
    //             } else {
    //                 return 'Client - View Only';
    //             }
    //         }else if ($accessLevel == 'standard+' && $viewOnlyPermission && $viewOnlyPermission->standardplus == 1) {
    //             if ($viewAndChangesPermission && $viewAndChangesPermission->standardplus == 1) {
    //                 return 'Both';
    //             } else {
    //                 return 'Client - View Only';
    //             }
    //         }else if ($accessLevel == 'advance' && $viewOnlyPermission && $viewOnlyPermission->advance == 1) {
    //             if ($viewAndChangesPermission && $viewAndChangesPermission->advance == 1) {
    //                 return 'Both';
    //             } else {
    //                 return 'Client - View Only';
    //             }
    //         }else if ($accessLevel == 'advance+' && $viewOnlyPermission && $viewOnlyPermission->advanceplus == 1) {
    //             if ($viewAndChangesPermission && $viewAndChangesPermission->advanceplus == 1) {
    //                 return 'Both';
    //             } else {
    //                 return 'Client - View Only';
    //             }
    //         }else if ($accessLevel == 'admin' && $viewOnlyPermission && $viewOnlyPermission->admin == 1) {
    //             if ($viewAndChangesPermission && $viewAndChangesPermission->admin == 1) {
    //                 return 'Both';
    //             } else {
    //                 return 'Client - View Only';
    //             }
    //         }else if ($accessLevel == 'accounts' && $viewOnlyPermission && $viewOnlyPermission->account == 1) {
    //             if ($viewAndChangesPermission && $viewAndChangesPermission->account == 1) {
    //                 return 'Both';
    //             } else {
    //                 return 'Client - View Only';
    //             }
    //         }
    //         // dd($accessLevel);
    //         // $accessLevel == 'targets';
    //         if ($accessLevel == 'targets' && $viewAndChangesPermission && $viewAndChangesPermission->targets == 1) {
    //             return 'Client - View & Make Changes';
    //         }
    //         if ($accessLevel == 'limited' && $viewAndChangesPermission && $viewAndChangesPermission->limited == 1) {
    //             return 'Client - View & Make Changes';
    //         }
    //         if ($accessLevel == 'standard' && $viewAndChangesPermission && $viewAndChangesPermission->standard == 1) {
    //             return 'Client - View & Make Changes';
    //         }
    //         if ($accessLevel == 'standard+' && $viewAndChangesPermission && $viewAndChangesPermission->standardplus == 1) {
    //             return 'Client - View & Make Changes';
    //         }
    //         if ($accessLevel == 'advance' && $viewAndChangesPermission && $viewAndChangesPermission->advance == 1) {
    //             return 'Client - View & Make Changes';
    //         }
    //         if ($accessLevel == 'advance+' && $viewAndChangesPermission && $viewAndChangesPermission->advanceplus == 1) {
    //             return 'Client - View & Make Changes';
    //         }
    //         if ($accessLevel == 'admin' && $viewAndChangesPermission && $viewAndChangesPermission->admin == 1) {
    //             return 'Client - View & Make Changes';
    //         }
    //         if ($accessLevel == 'accounts' && $viewAndChangesPermission && $viewAndChangesPermission->account == 1) {
    //             return 'Client - View & Make Changes';
    //         }

    //         return "No permission";
    //     }
    // }
    public function checkPermission($module)
    {
        // If the user is an admin, grant permission
        if ($this->role_type == "admin") {
            return true;
        } else {
            // Normalize access level
            $userId = Auth::id();
            $user = User::where('id',$userId)->first();

            $accessLevel = strtolower($this->access_level);
            // Fetch permissions for the specified module
            $permissions = Permissions::where('name', $module)->get();
            if ($permissions->isEmpty()) {
                return false; // No permission found for the module
            }
            foreach($permissions as $per)
            {
                $viewOnlyPermission = Permissions::where('name', $module)->where('sub_name', 'like', '%Only%')->first();
                if ($accessLevel == 'targets' && $viewOnlyPermission && $viewOnlyPermission->targets == 1) {
                    $pers = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
                    if($pers && $pers->targets == 1){
                        return 'Both';
                    }else{
                        return 'View Only';
                    }
                }else if ($accessLevel == 'limited' && $viewOnlyPermission && $viewOnlyPermission->limited == 1) {
                    $pers = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
                    if($pers && $pers->limited == 1){
                        return 'Both';
                    }else{
                        return 'View Only';
                    }
                }else if ($accessLevel == 'standard' && $viewOnlyPermission && $viewOnlyPermission->standard == 1) {
                    $pers = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
                    if($pers && $pers->standard == 1){
                        return 'Both';
                    }else{
                        return 'View Only';
                    }
                }else if ($accessLevel == 'standard+' && $viewOnlyPermission && $viewOnlyPermission->standardplus == 1) {
                    $pers = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
                    if($pers && $pers->standardplus == 1){
                        return 'Both';
                    }else{
                        return 'View Only';
                    }
                }else if ($accessLevel == 'advance' && $viewOnlyPermission && $viewOnlyPermission->advance == 1) {
                    $pers = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
                    if($pers && $pers->advance == 1){
                        return 'Both';
                    }else{
                        return 'View Only';
                    }
                }else if ($accessLevel == 'advance+' && $viewOnlyPermission && $viewOnlyPermission->advanceplus == 1) {
                    $pers = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
                    if($pers && $pers->advanceplus == 1){
                        return 'Both';
                    }else{
                        return 'View Only';
                    }
                }else if ($accessLevel == 'admin' && $viewOnlyPermission && $viewOnlyPermission->admin == 1) {
                    $pers = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
                    if($pers && $pers->admin == 1){
                        return 'Both';
                    }else{
                        return 'View Only';
                    }
                }else if ($accessLevel == 'accounts' && $viewOnlyPermission && $viewOnlyPermission->account == 1) {
                    $pers = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
                    if($pers && $pers->account == 1){
                        return 'Both';
                    }else{
                        return 'View Only';
                    }
                }
            }
            $viewOnlyPermission = Permissions::where('name', $module)->where('sub_name', 'like', '%Make Changes%')->first();
            if ($accessLevel == 'targets' && $viewOnlyPermission && $viewOnlyPermission->targets == 1) {
                return 'View & Make Changes';
            }
            if ($accessLevel == 'limited' && $viewOnlyPermission && $viewOnlyPermission->limited == 1) {
                return 'View & Make Changes';
            }
            if ($accessLevel == 'standard' && $viewOnlyPermission && $viewOnlyPermission->standard == 1) {
                return 'View & Make Changes';
            }
            if ($accessLevel == 'standard+' && $viewOnlyPermission && $viewOnlyPermission->standardplus == 1) {
                return 'View & Make Changes';
            }
            if ($accessLevel == 'advance' && $viewOnlyPermission && $viewOnlyPermission->advance == 1) {
                return 'View & Make Changes';
            }
            if ($accessLevel == 'advance+' && $viewOnlyPermission && $viewOnlyPermission->advanceplus == 1) {
                return 'View & Make Changes';
            }
            if ($accessLevel == 'admin' && $viewOnlyPermission && $viewOnlyPermission->admin == 1) {
                return 'View & Make Changes';
            }
            if ($accessLevel == 'accounts' && $viewOnlyPermission && $viewOnlyPermission->account == 1) {
                return 'View & Make Changes';
            }
            return "No permission";
        }
    }

    /**
     * Get all of the user_services for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_services(): HasMany
    {
        return $this->hasMany(UsersServices::class, 'user_id', 'id');
    }


}

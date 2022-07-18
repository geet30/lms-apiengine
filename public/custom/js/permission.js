function checkPermission(permission, userPermissions, appPermissions)
{      
    if (userPermissions.includes(permission) && appPermissions.includes(permission)) {
        return true;
    }
    return false;
}
 
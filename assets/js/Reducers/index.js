import { combineReducers } from 'redux';
import { profileId } from './profileId';
import { profilesList } from './profilesList';
import { username, password } from './username&password';
import { logged } from './isLoggedIn';

export const allReducer = combineReducers({
    profileId,
    profilesList,
    username, 
    password,
    logged
})
export const setProfilesList = profiles =>({
    type: 'setProfilesList',
    profiles
})
//////////////////////////////////////
export const setSelectedProfileButton = profileId =>({
    type: 'setSelectedProfileButton',
    profileId
})
////////////////////////////////////////
export const setUsername = (username) =>({
    type: 'setUsername',
    username
})

export const setPassword = (password) =>({
    type: 'setPassword',
    password
})

export const isLoggedIn = (logged) =>({
    type: 'isLoggedIn',
    logged
})
/////////////////////////////////////////
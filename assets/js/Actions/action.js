export const setProfilesList = profiles =>({
    type: 'setProfilesList',
    profiles
})
//////////////////////////////////////

export const setSelectedProfile = profile => ({
    type: 'setSelectedProfile',
    profile
})

/////////////////////////////////////////////////////
export const setEmail = email => ({
    type: 'setEmail',
    email
})

export const setFullName = name => ({
    type: 'setFullName',
    name
})

export const setUserId = userId => ({
    type: 'setUserId',
    userId
})

export const setTitle = title => ({
    type: 'setTitle',
    title
})

export const setCareerFormId = formId => ({
    type: 'setCareerFormId',
    formId
})

export const setProfessionId = professionId => ({
    type: 'setProfessionId',
    professionId
})

export const setRoles = roles => ({
    type: 'setRoles',
    roles
})

export const setLogged = logged => ({
    type: 'setLogged',
    logged
})

export const setTeams = teams => ({
    type: 'setTeams',
    teams
})

export const setChoiceList = choiceList => ({
    type: 'setChoiceList',
    choiceList
})

//////////////////////

export const setAnswers = (criteriaId, choiceId) =>({
    type: 'setAnswers',
    criteriaId,
    choiceId
})

export const setComment = (criteriaId, comment) => ({
    type: 'setComment',
    criteriaId,
    comment
})

export const restartAnswers = () => ({
    type: 'restartAnswers'
})

// export const removeAnswer = (criteriaId, choiceId) => ({
//     type: 'removeAnswer',
//     criteriaId,
//     choiceId
// })

export const resetApp = () =>({
    type: "RESET_APP"
})
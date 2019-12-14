// export const setProfilesList = profiles => ({
//   type: "setProfilesList",
//   profiles
// });
////////////////////////////////////// need to know when on manger page

export const setManagerPage = profile => ({
  type: "setSelectedProfile",
  profile
});

///////////////////////////////////////////////////// when user logins his data is saved here
export const setEmail = email => ({
  type: "setEmail",
  email
});

export const setFullName = name => ({
  type: "setFullName",
  name
});

export const setUserId = userId => ({
  type: "setUserId",
  userId
});

export const setTitle = title => ({
  type: "setTitle",
  title
});

export const setCareerFormId = formId => ({
  type: "setCareerFormId",
  formId
});

export const setProfessionId = professionId => ({
  type: "setProfessionId",
  professionId
});

export const setRoles = roles => ({
  type: "setRoles",
  roles
});

export const setLogged = logged => ({
  type: "setLogged",
  logged
});

export const setTeams = teams => ({
  type: "setTeams",
  teams
});
/////////////////////////// user answers are saved here
export const setAnswersUserSide = answers => ({
  type: "setAnswersFromUser",
  answers
});

export const restartAnswersUserSide = () => ({
  type: "restartAnswersFromUser"
});

export const updateChoiceAnswerUserSide = (criteriaId, choiceId) => ({
  type: "updateChoiceAnswer",
  criteriaId,
  choiceId
});

export const updateCommentAnswerUserSide = (criteriaId, comment) => ({
  type: "updateCommentAnswer",
  criteriaId,
  comment
});
//////////////////////////////////////////////// team lead answers are saved here
export const setAnswersTeamLeadSide = answers => ({
  type: "setAnswersFromTeamLead",
  answers
});

export const restartAnswersTeamLeadSide = () => ({
  type: "restartAnswersFromTeamLead"
});

export const updateChoiceAnswerTeamLeadSide = (criteriaId, choiceId) => ({
  type: "updateChoiceAnswerTeamLead",
  criteriaId,
  choiceId
});

export const updateCommentAnswerTeamLeadSide = (criteriaId, comment) => ({
  type: "updateCommentAnswerTeamLead",
  criteriaId,
  comment
});

////////////////////// setting answers for post to api

export const setAnswers = (criteriaId, choiceId, answerId) => ({
  type: "setAnswers",
  criteriaId,
  choiceId,
  answerId
});

export const setComment = (criteriaId, comment, answerId) => ({
  type: "setComment",
  criteriaId,
  comment,
  answerId
});

export const restartAnswers = () => ({
  type: "restartAnswers"
});

export const isActionCalled = bollean => ({
  type: "isActionCalled",
  bollean
});

/// reset redux store
export const resetApp = () => ({
  type: "RESET_APP"
});

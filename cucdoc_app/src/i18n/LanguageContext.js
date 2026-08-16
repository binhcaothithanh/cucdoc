import React, { createContext, useContext, useEffect, useMemo, useState } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { I18n } from 'i18n-js';
import { translations } from './translations';

const LANGUAGE_STORAGE_KEY = '@cucdoc/language';
const LanguageContext = createContext(null);

const i18n = new I18n(translations);
i18n.enableFallback = true;
i18n.defaultLocale = 'en';

export function LanguageProvider({ children }) {
  const [language, setLanguage] = useState(null);
  const [isReady, setIsReady] = useState(false);

  useEffect(() => {
    const restoreLanguage = async () => {
      try {
        const savedLanguage = await AsyncStorage.getItem(LANGUAGE_STORAGE_KEY);
        if (savedLanguage === 'en' || savedLanguage === 'vi') {
          setLanguage(savedLanguage);
        }
      } finally {
        setIsReady(true);
      }
    };

    restoreLanguage();
  }, []);

  const selectLanguage = async (nextLanguage) => {
    if (nextLanguage !== 'en' && nextLanguage !== 'vi') return;
    await AsyncStorage.setItem(LANGUAGE_STORAGE_KEY, nextLanguage);
    setLanguage(nextLanguage);
  };

  const value = useMemo(() => {
    i18n.locale = language || 'en';
    return { language, isReady, selectLanguage, t: i18n.t.bind(i18n) };
  }, [language, isReady]);

  return <LanguageContext.Provider value={value}>{children}</LanguageContext.Provider>;
}

export function useLanguage() {
  const context = useContext(LanguageContext);
  if (!context) throw new Error('useLanguage must be used inside LanguageProvider');
  return context;
}

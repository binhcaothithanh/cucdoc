import React from 'react';
import { StatusBar, StyleSheet, Text, TouchableOpacity, View } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { Languages, ChevronRight } from 'lucide-react-native';
import { useLanguage } from '../i18n/LanguageContext';

export default function LanguageSelectionScreen() {
  const { selectLanguage, t } = useLanguage();

  const chooseLanguage = async (language) => {
    await selectLanguage(language);
  };

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="light-content" />
      <View style={styles.content}>
        <View style={styles.iconCircle}>
          <Languages color="#FF6B00" size={38} />
        </View>
        <Text style={styles.title}>{t('language.title')}</Text>
        <Text style={styles.subtitle}>{t('language.subtitle')}</Text>

        <TouchableOpacity
          onPress={() => chooseLanguage('en')}
          style={styles.languageButton}
          accessibilityRole="button"
        >
          <Text style={styles.flag}>🇺🇸</Text>
          <View style={styles.languageCopy}>
            <Text style={styles.languageName}>{t('language.english')}</Text>
            <Text style={styles.languageNative}>English</Text>
          </View>
          <ChevronRight color="#FF6B00" size={20} />
        </TouchableOpacity>

        <TouchableOpacity
          onPress={() => chooseLanguage('vi')}
          style={styles.languageButton}
          accessibilityRole="button"
        >
          <Text style={styles.flag}>🇻🇳</Text>
          <View style={styles.languageCopy}>
            <Text style={styles.languageName}>{t('language.vietnamese')}</Text>
            <Text style={styles.languageNative}>Vietnamese</Text>
          </View>
          <ChevronRight color="#FF6B00" size={20} />
        </TouchableOpacity>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#0B0F19' },
  content: { flex: 1, justifyContent: 'center', padding: 28 },
  iconCircle: { width: 78, height: 78, borderRadius: 39, alignItems: 'center', justifyContent: 'center', backgroundColor: 'rgba(255,107,0,0.12)', marginBottom: 28 },
  title: { color: '#FFFFFF', fontSize: 30, fontWeight: '800', marginBottom: 10 },
  subtitle: { color: '#94A3B8', fontSize: 16, lineHeight: 23, marginBottom: 34 },
  languageButton: { minHeight: 82, flexDirection: 'row', alignItems: 'center', backgroundColor: '#161D2B', borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1, borderRadius: 16, paddingHorizontal: 18, marginBottom: 14 },
  flag: { fontSize: 29, marginRight: 16 },
  languageCopy: { flex: 1 },
  languageName: { color: '#FFFFFF', fontSize: 17, fontWeight: '700' },
  languageNative: { color: '#94A3B8', fontSize: 13, marginTop: 3 },
});
